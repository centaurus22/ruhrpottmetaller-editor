# API
This file describes the GET parameters to control the *ruhrpottmetaller-editor*.
## SYNOPSIS
* \[\?display=*\<display_type\>*\[&display_id=*\<display_id\>*\]\]
  \[&save=*\<save_type\>*&save_id=*\<save_id\>*&SPECIFIC_PARAMETERS\]\[\&month=*\<month\>*\]\[\&del=*\<del_type\>*&del_id=*\<del_id\>*\]
* \[?edit=*<edit_type>*\[&edit_id=*<edit_id>*]\[&SPECIFIC_PARAMETERS\]\]\[\&del=*\<del_type\>*&del_id=*\<del_id\>*\]

## PARAMETERS
If none of the parameters are specified, the *rpmetaller-editor* shows the concert overview of the current month.

Only one of the two parameters `display` and `edit` can be provided. If both are sent, the `edit` parameter overwrites the `display` option.

#### display
The `display` parameter lets the *rpmetaller-editor* shows an overview of saved data. The following values are possible:
* `display=concert`
* `display=band`
* `display=city`
* `display=venue`
* `display=export`
* `display=pref`
* `display=license`

##### display_id
If this parameter is provided only the data set with the submitted id is displayed. This behavior is currently implemented only for the `display=concert` parameter.

#### edit
The `edit` parameter overwrites the `display` parameter. It opens an edit-page to insert or update data of the specified type. The following values are possible:
* `edit=concert`

Data can also be provided by SPECIFIC_PARAMETERS. In this case, the corresponding input fields are pre-filled with that information.

##### edit_id
If a value is provided via the `edit_id` parameter, the *rpmetaller-editor* loads the data from the database into the edit page. Data from parameters listed under SPECIFIC_PARAMETERS override the information from the database.

#### save
With the `save` parameter, the *rpmetaller-editor* inserts the data transferred with the SPECIFIC_PARAMETERS in the database table that corresponds to the transmitted value. The following values are possible:
* `save=concert`
* `save=band`
* `save=city`
* `save=venue`
* `save=pref`

If the saving of the data fails, the corresponding editor page is opened with the data that could not be saved.

##### save_id
The `save_id` parameter makes the difference between inserting a new data set into the database and updating an existing data set. If the `save_id` parameter is specified and the corresponding data record is available, the data record is updated. If no id is given, a new record is created. Otherwise the system will issue an error.

##### del
It is possible to delete an entry from the database with the `del` parameter. The following values are possible:
* `del=concert`

##### del_id
The `del_id` specifies which database entry of the indicated type is deleted.

#### special
Values of `special` are automatically replaced by ordinary non-special parameters. This allows to choose those parameters from a drop down menu within the software. The following replacements are implemented in the *rpmetaller-editor*. Sometimes have to be combined with a corresponding data id.
* `special=concert`
  * `&type=add` is replaced with `edit=concert` and the `concert_id` parameter is deleted from the request string.
  * `&type=edit` is replaced with `edit=concert`.
  * `&type=published` is replaced with `save=concert&published=1`.
  * `&type=del` is replaced with `del=concert`.
  * `&type=sold_out` is replaced with `save=concert&sold_out=1`.
* `special=lineup`
  * `&type=add`
  * `&type=del`
  * `&type=up`
  * `&type=down`

#### month
The `month` parameter in the format YYYY-MM is relevant for sites displaying a concert overview. In combination with `display=concert` or `display=export` the `month` parameter changes the output from the current month to a specific month.

### SPECIFIC_PARAMETERS
* *`concert`*
  * `name`: Name of the concert or festival.
  * `date_start`: Date of concert or the first day of the festival.
  * `length`: Length of the concert in days.
  * `city_id`: 1 of a new city. Otherwise ignored.
  * `city_new_name`: Name of a new city. Is only accepted if `city_id` is 1.
  * `venue_id`: Id of the venue where the concert takes place.
  * `venue_new_name`: Name of the new venue. Is only accepted if `venue_id` or `city_id` is 1.
  * `venue_url`: Standard URL of the new venue.
  * `url`: Link to official information about the concert.
  * `first_sign[]`: First character of the band name.
  * `band_id[]`: Id of a band.
  * `band_new_name[]`: Name of a new band which is not saved in the database yet. Is only accepted if the band_id in the same row is 3.
  * `addition[]`: Further information about the set of the band.

Each array listed above must have the same length and every array except the band_id[] array must be provided.
* *`band`*
  * `name`: Name of the band.
  * `visible`: Export status of the band. 1 -> is exported, 0 is not exported.
* *`city`*
  * `name`: Name of the city.
* *`venue`*
  * `name`: Name of the venue.
  * `city_id`: Id of the city in which the venue is located (Only relevant by adding a new venue).
  * `url`: Default URL of the venue.
* *`pref`*
  * `export_lang`: Language of the concert exports (Currently de_DE or default).
  * `header`: Header of the export page.
  * `footer`: Footer of the export page.
