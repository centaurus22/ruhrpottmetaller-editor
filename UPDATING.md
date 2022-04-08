# Updating instructions

Here you can find the latest updating instructions.

## Update to Version 3.0.0

* The database structure has changed in the following way. You have to adjust
  your database to complete your update.

  |  old              |  new                   |
  |-------------------|------------------------|
  | **`event`**       | **`event`**            |
  | datum_beginn      | date_start             |
  | datum_end         | date_end               |
  | location_id       | venue_id               |
  | publiziert        | published              |
  | ausverkauft       | sold_out               |
  | **`event_band`**  | **`event_band`**       |
  | zusatz            | additional_information |
  | **`location`**    | **`venue`**            |
  | stadt_id          | city_id                |
  | url               | url_standard           |
  | **`preferences`** | **`preferences`**      |
  | header            | export_header          |
  | footer            | export_footer          |
  | **`stadt`**       | **`city`**             |

* The index.php file of the Application is moved to the `/web` folder and
  therefore your web server configuration needs to be changed.
