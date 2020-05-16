# Using
This section describes, how to use the software. Every link at the top has its own subsection.

On some sites it is possible to narrow down the displayed items by month or first letter. In this case, a second row with form elements is displayed.
## Termine
This is the main site of the *rpmetaller-editor*.
You can use the buttons at the top of the page to browse through all concerts saved in the database. You can also jump back to the current month by clicking the button with the small circle.

Clicking at the plus image at the left of a concert opens a human readable export. Export settings can be made on the [Einstellungen](#einstellungen) site.

Several commands can be applied to a concert using the drop down menu at the right:
* `add` opens the [concert editor](#concert-editor) to add a new concert to the database. The date of the concert on which you start the add command, is the preset for the date of the new concert.
* `edit` opens the [concert editor](#concert-editor) to edit the concert data.
* `publiziert` marks the concert as published.
* `del` deletes the concert from the database. It is therefore irrevocably deleted from the system.
* `sold out` marks the concert as sold out. As a result, the corresponding concert exports are generated with the information that the concert is sold out. This affects this site and the [Export](#export) site.

A concert can be displayed in different colors:
* black: The concert is already marked as published.
* blue: The concert has not yet been marked as published. 
* red: The concert has not yet been marked as published and will be within the next two weeks. If it is a festival (a concert with more than one day) it will be within the next 60 days.
### Concert editor
This is the tool for adding or editing concerts. The only necessary input fields for saving the concert are the date and the location.

#### In the first part of the editor general information of the concert are entered.
If the name of the first band is included in the concert name, it will not be shown again in the lineup section of the concert export. Instead, a plus sign is displayed.

The date of the concert has to be added in the form “YYYY-MM-DD”.

If a city is not yet in the database, it is possible to add it by selecting the option “Neue Stadt” from the bottom of the drop down menu, which is opened by clicking on the city name.  If a city menu option is already selected, a new location can be added to the database. In this case you have to select the option "Neue Location" in the second dropdown menu.

#### The second part of the editor is the lineup editor.

Each row represents a band in the lineup.

If you choose a character in the first dropdown menu, bands with those initial letter are loaded in the second one. Also you can add a new band to the database and the lineup by choosing the last option of the menu. The hash symbol stands for special characters. If you do not select a character in the first dropdown menu, you can choose between also adding a new band to the database and the lineup or an entry with “TBA“ (To be anounced) or “Support”.

The input field labeled with “Zusatz” serves for additional information about this show by this band. This may be the information about an acoustic show or a special set.

Clicking the four buttons at the end of the line have the following effect:
* Minus sign: Deletes the band from the lineup
* Plus sign: Adds a band under the current line
* Arrow signs: Moves the band in the lineup up or down
## Bands
On this site you can edit the names of the bands in the database. After changing the band name, you need to click anywhere outside the text box to save the change. You can filter the band by the first letter of its name using the dropdown menu at the top.

Also you can mark them as not exportable. In this case, the band is written in light brown letters in the concert overview on the [Termine](#termine) site. Also concerts with the corresponding band are not be included in the export on the [Export](#export) site. 
## Städte
On this site you can edit the names of the cities in the database. After changing the city name, you need to click anywhere outside the text box to save the change.

The checkbox right of the city name is intended for an external functionality and does not have any affect on the *rpmetaller-editor*. 
## Locations
On this site you can edit the names of the venues in the database. The system can contain multiple venues with the same name as long as they are in different cities. A URL for each venue can also be added to the database. If you select the venue in the [concert editor](#concert-editor) and the URL field is still empty, this URL will be filled in there.

After changing one of the input fields, you need to click anywhere outside the text field to save the change.
The checkbox in the column “Anzeigen“ is intended for an external functionality and does not have any affect on the *rpmetaller-editor*. 
## Export
A human readable list of the concerts of the currently selected month is created on the export page.
The header and the footer can be configured on the [Einstellungen](#einstellungen) site.
You can scroll through the months at the top of the page. You can also jump to the current month by clicking the button with the small circle.
## Einstellungen
Using this site a few preferences can be made.

The checkboxes are control the generation of concert exports on the [Termine](#termine) site.
* The first checkbox determines whether an @ symbol is generated before every Facebook export.
* The second checkbox determines wether a twitter export is generated.
* The third checkbox determines if a facebook export is displayed.

The two text areas allow to change the header and the footer of the export generated on the [Export](#export) site. After making changes to the text areas you have to click outside it to save the adjustments.
