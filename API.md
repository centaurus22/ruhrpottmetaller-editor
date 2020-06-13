# API
This file describes the parameter to controll the *ruhrpottmetaller-editor*.
## SYNOPSIS
* \[\?display_type=*\<display_type\>*\[&display_id=*\<display_id\>*\]\[&special=sub\]\]
  \[&save_type=*\<save_type\>*&save_id=*\<save_id\>*&SPECIFIC_INFORMATION\]\[\&month=*\<month\>*\]
* \[?edit_type=*<edit_type>*\[&edit_id=*<edit_id>*]\[&SPECIFIC_INFORMATION\]\]
## OPTIONS
If none of the options are specified, the *rpmetaller-editor* only shows the concert overview of the current month.

Only one of the two options `display_type` and `edit_type` can be provided. If both are sent, the `èdit_type` option overwrites the `display_type` option.
#### display_type
The `display_type` option let the *rpmetaller-editor* shows an overwiev of saved data. The following values are possible:
* display_type=concert
* display_type=band
* display_type=city
* display_type=venue
* display_type=export
* display_type=pref
* display_type=license
##### display_id
If this option is provided *without* the `special=sub` option only the dataset with the submitted id is displayed. This behaviour is currently implemented for the `display_type=concert` option. 
##### special=sub
The `special=sub` option is for the purpose of Ajax calls. If this option is provided, the logically following menu items are limited by higher-level objects with this id. For example, if `display_type=city` in combination with `display_id=<city_id>` and `special=sub` is provided the *rpmetaller-editor* provides the dropdown menue options with venues in this city.
#### edit_type
The `èdit_type` option overwrites the `display_type` option. It opens an edit-page for handling and saving data of the specified type. The following values are possible:
* edit_type=concert
* edit_type=band
* edit_type=city
* edit_type=venue

Data can also be provided by SPECIFIC_INFORMATION. In this case, the corresponding input fields are pre filled with that information.
##### edit_id
If a value is provided via the `edit_id` option, the *rpmetaller-editor* loads the data from the database into the edit-page. Data from the SPECIFIC_INFORMATION override the information from the database.
#### save_type
With the `save_type` option, the * rpmetaller-editor * can save the data transferred with the SPECIFIC_INFORMATION in the database table that corresponds to the transmitted value. The following values are possible:
* save_type=concert
* save_type=band
* save_type=city
* save_type=venue
* save_type=pref

If the saving of the data fails, the corresponding editor page is opened with the data that could not be saved. If it could be saved, the page specified with the option `display_type` is displayed. If this option is not activated. The *rpmetaller-editor* only prints out a success report.
##### save_id
The `save_id` option makes the difference between creating a new dataset in the database and updating an existing dataset. If an id is specified and the corresponding data record is available, the data record is updated. If no id is given, a new record is created. Otherwise the system will issue an error.
#### month
The `month` option in the format YYYY.MM is relevant for sites displaying a concert overview. In combination with `display_type=concert` or `display_type=export` the `month` option changes the output from the current month to a specific month.
### SPECIFIC_INFORMATION
* `edit_type
  * *`concert`*
    * `name`
    * `date`
    * `length`
    * `city_id`
    * `city_name`
    * `venue_id`
    * `venue_name`
    * `url`
    * `band_id\[\]`
    * `addition\[\]`
  * *`band`*
    * `name`
    * `nazi`
  * *`city`*
    * `name`
  * *`venue`*
    * `name`
    * `city_id`
    * `url`
* `save_type`
  * *`concert`*
    * `name`
    * `date`
    * `length`
    * `city_id`
    * `city_name`
    * `venue_id`
    * `venue_name`
    * `url`
    * `band_id\[\]`
    * `addition\[\]`
    * `published`
    * `sold_out`
  * *`band`*
    * `name`
    * `nazi`
  * *`city`*
    * `name`
  * *`venue`*
    * `name`
    * `city_id`
    * `url`
  * *`pref`*
    * display_at
    * header
    * footer
