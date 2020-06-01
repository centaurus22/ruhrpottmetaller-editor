# API
This file describes the parameter to controll the *ruhrpottmetaller-editor*.
## SYNOPSIS
* \[\?display_type=*\<display_type\>*\[&display_id=*\<display_id\>*\]\[&special=sub\]\]
  \[&save_type=*\<save_type\>*&save_id=*\<save_id\>*&SPECIFIC_INFORMATION\]\[\&month=*\<month\>*\]
* \[?edit_type=*<edit_type>*\[&edit_id=*<edit_id>*]\[&SPECIFIC_INFORMATION\]\]\[&save_type=*<save_type>*&save_id=*<save_id>*
&SPECIFIC_INFORMATION\]\[\&month=*\<month\>*\]
## OPTIONS
If none of the options are specified, the *rpmetaller-editor* only shows the concert overview of the current month.

Only one of the two options `display_type` and `edit_type` can be provided. If both are sent, the `èdit_type` option overwrites the `display_type` option. The `save_type` option can always be provided.
#### display_type
The `display_type` option let the *rpmetaller-editor* shows an overwiev of saved data. The following values are possible:
* display_type=concert
* display_type=citie
* display_type=venue
* display_type=export
* display_type=pref
##### display_id
If this option is provided *without* the `special=sub` option only the dataset with the submitted id is displayed. This behaviour is currently implemented for the `display_type=concert` option. 
##### special=sub
The `special=sub` option is for the purpose of Ajax calls. If this option is provided, the logically following menu items are limited by higher-level objects with this id. For example, if `display_type=citie` in combination with `display_id=<city_id>` and `special=sub` is provided the *rpmetaller-editor* provides the dropdown menue options with venues in this city.
#### edit_type
##### edit_id
#### save_type
##### save_id
#### month
### SPECIFIC_INFORMATION
