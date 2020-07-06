# API
This file describes the parameters to controll the *rpmetaller-editor*.
## SYNOPSIS
* \[\?display=*\<display_type\>*\[&display_id=*\<display_id\>*\]\[&special=sub\]\]
  \[&save=*\<save_type\>*&save_id=*\<save_id\>*&SPECIFIC_INFORMATION\]\[\&month=*\<month\>*\]\[\&del=*\<del_type\>*&del_id=*\<del_id\>*\]
* \[?edit=*<edit_type>*\[&edit_id=*<edit_id>*]\[&SPECIFIC_INFORMATION\]\]\[\&del=*\<del_type\>*&del_id=*\<del_id\>*\]
## PARAMETERS
If none of the parameters are specified, the *rpmetaller-editor* only shows the concert overview of the current month.

Only one of the two parameters `display` and `edit` can be provided. If both are sent, the `èdit` parameter overwrites the `display` option.
#### display
The `display` parameter lets the *rpmetaller-editor* shows an overwiev of saved data. The following values are possible:
* display=concert
* display=band
* display=city
* display=venue
* display=export
* display=pref
* display=license
##### display_id
If this parameter is provided *without* the `special=sub` parameter only the dataset with the submitted id is displayed. This behaviour is currently implemented only for the `display=concert` option. 
##### special=sub
The `special=sub` parameter is for the purpose of Ajax calls. If this parameter is provided, the logically following menu items are limited by higher-level objects with this id. For example, if `display=city` in combination with `display_id=<city_id>` and `special=sub` is provided the *rpmetaller-editor* provides the dropdown menue options with venues in this city.
#### edit
The `èdit` parameter overwrites the `display` parameter. It opens an edit-page for handling and saving data of the specified type. The following values are possible:
* edit=concert
* edit=band
* edit=city
* edit=venue

Data can also be provided by SPECIFIC_INFORMATION. In this case, the corresponding input fields are pre filled with that information.
##### edit_id
If a value is provided via the `edit_id` parameter, the *rpmetaller-editor* loads the data from the database into the edit-page. Data from the SPECIFIC_INFORMATION override the information from the database.
#### save
With the `save` parameter, the * rpmetaller-editor * can save the data transferred with the SPECIFIC_INFORMATION in the database table that corresponds to the transmitted value. The following values are possible:
* save=concert
* save=band
* save=city
* save=venue
* save=pref

If the saving of the data fails, the corresponding editor page is opened with the data that could not be saved. If it could be saved, the page specified with the option `display` is displayed. If this parameter is not activated. The *rpmetaller-editor* only prints out a success report.
##### save_id
The `save_id` parameter makes the difference between creating a new dataset in the database and updating an existing dataset. If an id is specified and the corresponding data record is available, the data record is updated. If no id is given, a new record is created. Otherwise the system will issue an error.
##### del
It is possible to delete an entry from the database with the `del` option. The following values are possible:
* del=concert
##### del_id
The `del_id`specifies which database entry of the indicated type is deleted.
#### month
The `month` parameter in the format YYYY-MM is relevant for sites displaying a concert overview. In combination with `display=concert` or `display=export` the `month` parameter changes the output from the current month to a specific month.
### SPECIFIC_INFORMATION
* `edit
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
* `save`
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
