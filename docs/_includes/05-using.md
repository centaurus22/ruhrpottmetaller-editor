# Using
This section describes, how to use the software. Every link at the top has its own subsection.

On some sites it is possible to narrow down the displayed items by month, first letter or other categories. In this case, a second row with form elements is displayed.

The concert editor as well as the concert export function need JavaScript activated in your browser. So do not forget to activate it for the application.
## Concerts
![Screenshot of the Termine site](https://raw.githubusercontent.com/klaus-thorres/rpmetaller-editor/main/docs/_images/01-termine.jpeg)

This is the main site of the *rpmetaller-editor*.
You can use the buttons at the top of the page to browse through all concerts saved in the database. You can also jump back to the current month by clicking the button with the small circle.

Clicking at the plus image at the left of a concert opens a human readable export.  Export settings can be made on the [Preferences](#export) site.

Several commands can be applied to a concert using the drop down menu at the right:
* `Add` opens the [concert editor](#concert-editor) to add a new concert to the database. The date of the concert on which the add command is started, is the preset for the date of the new concert.
* `Edit` opens the [concert editor](#concert-editor) to edit the concert data.
* `Published` marks the concert as published.
* `Del` deletes the concert from the database. It is therefore irrevocably deleted from the system.
* `Sold Out` marks the concert as sold out. As a result, the corresponding concert exports are generated with the information that the concert is sold out. This affects this site and the [Export](#export) site.

A concert is displayed in one of the following colors:
* black: The concert is already marked as published.
* blue: The concert has not yet been marked as published. 
* red: The concert has not yet been marked as published and will be within the next two weeks. If it is a festival (a concert with more than one day) it will be within the next 60 days.

### Concert editor
![Screenshot of the concert editor](https://raw.githubusercontent.com/klaus-thorres/rpmetaller-editor/main/docs/_images/07-concert-editor.jpeg)

This is the tool for adding or editing concerts. The only necessary input fields for saving the concert are the date and the location.

#### General concert data
In the first part of the editor general information of the concert are entered.

If a city is not yet in the database, it is possible to add it by selecting the option “New city” from the bottom of the city drop down menu. If a city menu option is already selected, a new venue can be added to the database. In this case you have to select the option "New venue" in the second dropdown menu. (Tipp: Press "n" a few times until the option shows up.)

The new venue input field is automatically shown if you insert a new city. Also by creating new venues you can enter a default url. This will be putted in the URL field when you choose a venue and the URL is not yet set to spare you a few clicks.

#### Concert lineup
Each row represents a band in the lineup.

If you choose a character in the first dropdown menu, bands with those initial letter are loaded in the second one. The percentage symbol stands for special characters. Also you can add a new band to the database and the lineup by choosing the last option of the second menu. If you do not select a character in the first dropdown menu, you can choose between also adding a new band to the database and the lineup or an entry which is labeled “TBA“ (To be anounced) or “Support”.

The input field named “Extra information” serves for additional information about this show by this band. This may be the information about an acoustic show or a special set.

Clicking one of the four buttons at the end of the row has the following effect:
* Plus sign: Adds a band under the current row
* Minus sign: Deletes the band from the lineup
* Arrow signs: Moves the band in the lineup up or down

As you can see, most of your work can be done just on this two pages. 

## Bands
![Screenshot of the bands site](https://raw.githubusercontent.com/klaus-thorres/rpmetaller-editor/main/docs/_images/02-bands.jpeg)

On this site you can edit the names of the bands in the database.
Also you can mark them as not visible. In this case, the band is written in light brown letters in the [concert overview](#concerts). Also concerts with the corresponding band are not be included in the export on the [Export](#export) site.

Filtering the bands by the first character of its name using the dropdown menu at the top.
## Cities
![Screenshot of the Städte site](https://raw.githubusercontent.com/klaus-thorres/rpmetaller-editor/main/docs/_images/03-staedte.jpeg)

On this site you can edit the names of the cities in the database. 

Filtering by the the first character is also possible on this page.
## Locations
![Screenshot of the Locations site](https://raw.githubusercontent.com/klaus-thorres/rpmetaller-editor/master/docs/_images/04-locations.jpeg)

On this site you can edit the names of the venues in the database. The system can contain multiple venues with the same name as long as they are in different cities. A URL for each venue can also be added to the database. If you select the venue in the [concert editor](#concert-editor) and the URL field is still empty, this URL will be filled in there.

After changing one of the input fields, you need to click anywhere outside the text field to save the change.
The checkbox in the column “Anzeigen“ is intended for an external functionality and does not have any affect on the *rpmetaller-editor*. 
## Export
![Screenshot of the Export site](https://raw.githubusercontent.com/klaus-thorres/rpmetaller-editor/master/docs/_images/05-export.jpeg)

A human readable list of the concerts of the currently selected month is created on the export page.
The header and the footer can be configured on the [Einstellungen](#einstellungen) site.
You can scroll through the months at the top of the page. You can also jump to the current month by clicking the button with the small circle.
## Einstellungen
![Screenshot of the Einstellungen site](https://raw.githubusercontent.com/klaus-thorres/rpmetaller-editor/master/docs/_images/06-einstellungen.jpeg)

Using this site a few preferences can be made.

The checkboxes are control the generation of concert exports on the [Termine](#termine) site.
* The first checkbox determines whether an @ symbol is generated before every Facebook export.
* The second checkbox determines wether a twitter export is generated.
* The third checkbox determines if a facebook export is displayed.

The difference between Facebook and Twitter export are that shorter terms are used for the Twitter export and the number of bands can be reduced to meet the 280 characters limit.

The two text areas allow to change the header and the footer of the export generated on the [Export](#export) site. After making changes to the text areas you have to click outside it to save the adjustments.
