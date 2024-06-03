<?php

/**
 * Transfers the data to a database in the new ruhrpottmetaller-editor 3.0.0
 * format.
 *
 * Attendtion: This deletes all data in the target database!
 * */

namespace RuhrpottMetaller;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$source_server_url = 'localhost';
$source_database_name = '';
$source_login_name = '';
$source_login_password  = '';

$target_server_url = 'localhost';
$target_database_name = '';
$target_login_name = '';
$target_login_password  = '';

class TransferData
{
    private string $source_server_url;
    private string $source_database_name;
    private string $source_login_name;
    private string $source_login_password;
    private string $target_server_url;
    private string $target_database_name;
    private string $target_login_name;
    private string $target_login_password;
    private \mysqli $source_mysqli;
    private \mysqli $target_mysqli;

    public function __construct(
        string $source_server_url,
        string $source_database_name,
        string $source_login_name,
        string $source_login_password,
        string $target_server_url,
        string $target_database_name,
        string $target_login_name,
        string $target_login_password
    ) {
        $this->source_server_url = $source_server_url;
        $this->source_database_name = $source_database_name;
        $this->source_login_name = $source_login_name;
        $this->source_login_password = $source_login_password;
        $this->target_server_url = $target_server_url;
        $this->target_database_name = $target_database_name;
        $this->target_login_name = $target_login_name;
        $this->target_login_password = $target_login_password;
    }

    public function execute(): void
    {
        $this->connectToDatabases();
        $this->deleteTargetDatabase();
        $this->transferEventData();
        $this->transferBandData();
        $this->transferEventBandData();
        $this->transferCityData();
        $this->transferVenueData();
        $this->transferPreferencesData();
    }

    private function connectToDatabases(): void
    {
        $this->connectToSourceDatabase();
        $this->connectToTargetDatabase();
    }

    private function connectToSourceDatabase(): void
    {
        $this->source_mysqli = new \mysqli(
            $this->source_server_url,
            $this->source_login_name,
            $this->source_login_password,
            $this->source_database_name
        );
    }

    private function connectToTargetDatabase(): void
    {
        $this->target_mysqli = new \mysqli(
            $this->target_server_url,
            $this->target_login_name,
            $this->target_login_password,
            $this->target_database_name
        );
    }

    private function deleteTargetDatabase(): void
    {
        $queries[] = 'TRUNCATE event';
        $queries[] = 'TRUNCATE event_band';
        $queries[] = 'TRUNCATE band';
        $queries[] = 'TRUNCATE city';
        $queries[] = 'TRUNCATE venue';
        $queries[] = 'TRUNCATE preferences';

        foreach ($queries as $query) {
            $this->target_mysqli->query($query);
        }
    }

    private function transferEventData()
    {
        $eventBands = $this->getEventDataFromSource();
        $this->writeEventDataToTarget($eventBands);
    }

    private function getEventDataFromSource(): \mysqli_result
    {
        $query = '
            SELECT
                id,
                name,
                datum_beginn,
                datum_ende,
                location_id,
                url,
                publiziert,
                ausverkauft
            FROM event
        ;';
        return $this->source_mysqli->query($query);
    }

    private function writeEventDataToTarget(\mysqli_result $eventData): void
    {
        while ($Event = $eventData->fetch_object()) {
            if (is_null($Event->datum_ende)) {
                $query = sprintf(
                    '
                        INSERT INTO event
                        SET
                            id = "%1$s",
                            name = "%2$s",
                            date_start = "%3$s",
                            venue_id = "%4$s",
                            url = "%5$s",
                            sold_out = %6$u,
                            published = %7$u
                    ',
                    $Event->id,
                    $this->target_mysqli->real_escape_string($Event->name),
                    $Event->datum_beginn,
                    $Event->location_id,
                    $this->target_mysqli->real_escape_string($Event->url),
                    $Event->ausverkauft,
                    $Event->publiziert
                );
            } else {
                $query = sprintf(
                    '
                        INSERT INTO event
                        SET
                            id = "%1$s",
                            name = "%2$s",
                            date_start = "%3$s",
                            date_end = "%4$s",
                            venue_id = "%5$s",
                            url = "%6$s",
                            sold_out = %7$u,
                            published = %8$u
                    ',
                    $Event->id,
                    $this->target_mysqli->real_escape_string($Event->name),
                    $Event->datum_beginn,
                    $Event->datum_ende,
                    $Event->location_id,
                    $this->target_mysqli->real_escape_string($Event->url),
                    $Event->ausverkauft,
                    $Event->publiziert
                );
            }
            $this->target_mysqli->query($query);
        }
    }

    private function transferBandData(): void
    {
        $bands = $this->getBandDataFromSource();
        $this->writeBandDataToTarget($bands);
    }

    private function getBandDataFromSource(): \mysqli_result
    {
        $query = '
            SELECT
                id,
                name,
                visible
            FROM band
        ;';
        return $this->source_mysqli->query($query);
    }

    private function writeBandDataToTarget(\mysqli_result $bandData): void
    {
        while ($Band = $bandData->fetch_object()) {
            $query = sprintf(
                '
                    INSERT INTO band
                    SET
                        id = %1$u,
                        name = "%2$s",
                        visible = %3$u
                ',
                $Band->id,
                $this->target_mysqli->real_escape_string($Band->name),
                $Band->visible
            );
            $this->target_mysqli->query($query);
        }
    }

    private function transferEventBandData()
    {
        $eventBands = $this->getEventBandDataFromSource();
        $this->writeEventBandDataToTarget($eventBands);
    }

    private function getEventBandDataFromSource(): \mysqli_result
    {
        $query = '
            SELECT
                event_id,
                band_id,
                zusatz
            FROM event_band
        ;';
        return $this->source_mysqli->query($query);
    }

    private function writeEventBandDataToTarget(
        \mysqli_result $eventBandData
    ): void {
        while ($EventBand = $eventBandData->fetch_object()) {
            $query = sprintf(
                '
                    INSERT INTO event_band
                    SET
                        event_id = %1$u,
                        band_id = %2$u,
                        additional_information = "%3$s"
                ',
                $EventBand->event_id,
                $EventBand->band_id,
                $this->target_mysqli->real_escape_string($EventBand->zusatz)
            );
            $this->target_mysqli->query($query);
        }
    }

    private function transferCityData(): void
    {
        $cities = $this->getCityDataFromSource();
        $this->writecityDataToTarget($cities);
    }

    private function getCityDataFromSource(): \mysqli_result
    {
        $query = '
            SELECT
                id,
                name,
                visible
            FROM stadt
        ;';
        return $this->source_mysqli->query($query);
    }

    private function writeCityDataToTarget(\mysqli_result $cityData): void
    {
        while ($City = $cityData->fetch_object()) {
            $query = sprintf(
                '
                    INSERT INTO city
                    SET
                        id = %1$u,
                        name = "%2$s",
                        visible = %3$u
                ',
                $City->id,
                $this->target_mysqli->mysqli_real_escape_string($City->name),
                $City->visible
            );
            $this->target_mysqli->query($query);
        }
    }

    private function transferVenueData(): void
    {
        $venues = $this->getVenueDataFromSource();
        $this->writevenueDataToTarget($venues);
    }

    private function getVenueDataFromSource(): \mysqli_result
    {
        $query = '
            SELECT
                id,
                name,
                stadt_id,
                url,
                visible
            FROM location
        ;';
        return $this->source_mysqli->query($query);
    }

    private function writeVenueDataToTarget(\mysqli_result $venueData): void
    {
        while ($Venue = $venueData->fetch_object()) {
            if (is_null($Venue->url)) {
                $query = sprintf(
                    '
                        INSERT INTO venue
                        SET
                            id = %1$u,
                            name = "%2$s",
                            city_id = %3$u,
                            visible = %4$u
                    ',
                    $Venue->id,
                    $this->target_mysqli->mysqli_real_escape_string($Venue->name),
                    $Venue->stadt_id,
                    $Venue->visible
                );
            } else {
                $query = sprintf(
                    '
                        INSERT INTO venue
                        SET
                            id = %1$u,
                            name = "%2$s",
                            city_id = %3$u,
                            url_standard = "%4$s",
                            visible = %5$u
                    ',
                    $Venue->id,
                    $this->target_mysqli->mysqli_real_escape_string($Venue->name),
                    $Venue->stadt_id,
                    $Venue->url,
                    $Venue->visible
                );
            }
            $this->target_mysqli->query($query);
        }
    }

    private function transferPreferencesData(): void
    {
        $preferences = $this->getPreferencesDataFromSource();
        $this->writePreferencesDataToTarget($preferences);
    }

    private function getPreferencesDataFromSource(): \mysqli_result
    {
        $query = '
            SELECT
                header,
                footer,
                export_lang
            FROM preferences
        ';
        return $this->source_mysqli->query($query);
    }

    private function writePreferencesDataToTarget(
        \mysqli_result $preferencesData
    ): void {
        while ($Preferences = $preferencesData->fetch_object()) {
            var_dump($Preferences);
            $query = sprintf(
                '
                    INSERT INTO preferences
                    SET
                        id = 1,
                        export_header = "%1$s",
                        export_footer = "%2$s",
                        export_lang = "%3$s"
                ',
                $this->target_mysqli->real_escape_string($Preferences->header),
                $this->target_mysqli->real_escape_string($Preferences->footer),
                $Preferences->export_lang
            );
            $this->target_mysqli->query($query);
        }
    }
}

$TransferDatabase = new TransferData(
    $source_server_url,
    $source_database_name,
    $source_login_name,
    $source_login_password,
    $target_server_url,
    $target_database_name,
    $target_login_name,
    $target_login_password
);

$TransferDatabase->execute();
