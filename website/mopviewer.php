<?php
session_start();
include("includes/header.php");
include("menu.php");
?>
<div id="content">
	<h2>MopViewer</h2>
	<p>MopViewer is the program used to view the time series files produced by Moody.</p> 
    <img src="images/mopviewer_gui.png" alt= "MopViewer User Interface"></img>
	<p>MopViewer is available compiled for Windows and Linux, and you can use the source code to compile for other platforms.</p>
	<h3>Compiling MopViewer</h3>
	<p>MopViewer is cross platform, so you can compile it to run on any platform for which QT is available. </p>
	<h4>Compiling with QT Creator</h4>
	<p>Open the MopViwer.pro project file found in moody/mopviewer in QT Creator, select <span style=" font-weight: bold;">release</span> in the build type and then <span style=" font-weight: bold;">build MopViewer</span> from the build menu</p>
	<p>I used QT Creator to write and compile MopViewer. You can either use that yourself, or compile MopViewer from the command line</p>
	<h4>Compilation From a Console</h4>
	<p>cd to the directory moody/mopviewer/ and type <span style=" font-weight: bold;">qmake &amp;&amp; make</span>. The binary should be in moody/MopViewer-build-desktop/release/</p>
	<h3>Controls</h3>
	<p>Before starting this section I suggest you download one of the demonstration time series results (mop files) from the <a href="http://www.politespider.com/moody/downloads.php" style = "color: #F26522;font-weight: bold; text-decoration: underline;" >downloads page</a></p>
	<h4>Play/Pause Button</h4>
	<p>Either begins or pauses the playback of the current mop file</p>
	<h4>Restart Button</h4>
	<p>Resets the mop file back to the beginning and resumes playback from that point</p>
	<h4>Playback Delay</h4>
	<p>This is the delay in milliseconds that mopviewer will use between displaying states. A setting of <b>0</b> will mean that the only delay betweeen states is the time taken to load each successive state from file and process it for display.</p>
	<h4>Zoom Level</h4>
	<p>Mopviewer defaults to a scale which allows every particle in the first state loaded to be visible in the display. Higher zoom levels will no longer show all particles, but will reveal more detail. You can change the particle on which the view is centered so as to zoom in on different regions of a state</p>
	<p>Maximising the main window will provide a greater display area for the particles being displayed.</p>
	<h4>Show Trails Checkbox</h4>
	<p>If you want particles to have trails in the display, check this option. If you only want trails for the two selected particles, choose that option as well.</p>
	<p>You can specify a different trail length. There's no hard upper limit on the size of trails, but do be aware that trails require a lot of memory.</p>
	<h4>Show Placemark Particles Checkbox</h4>
	<p>Placemark particles are non interactive position indicators used by Moody to indicate fixed points in a time series. They might for instance indicate positions along a particles orbit, or the position at which an event of interest occured. You can choose whether or not to display them, default is for them to be displayed if present.</p>
	<img src="images/placemarks.png" alt= "placemarks"></img>
	<p>The above image show the the three example placemarks currently in the Reference Project. Each is one AU distant from the Sun, one per axis. </p>
	<h4>Save the current state to an image file</h4>
	<p>This records a png image of the state currently being displayed, storing it in the same folder as the mop file being played. </p>
	<h4>Rotating The View</h4>
	<p>You can rotate the view by either using the slider bars or by clicking on the display and holding down the left mouse button for X and Y axis rotation or right mouse button for the Z axis. The reset button will return you to the default viewing angle.</p>
	<h4>Change Focus Particle</h4>
	<p>By default mopviewer will use the first particle it finds in a state as the focus particle during playback. If you want to focus display around a different particle, you select its index here. This is particulerly neccesary if you want to zoom in close on a planet and view its moons.</p>
	<p>Here the focus particle is Jupiter, and we are zoomed in close enough to see the Galilean Moons.</p>
    <img src="images/JupiterCloseUp.png" alt= "Jupiter"></img>
	<h4>Selected Particles</h4>
	<p>The purpose of the selected particle feature is to allow you to examine/demonstrate the properties of two particles in your model. For example, if one of the particles represents a spacecraft you can use this feature to show both the spacecraft and its destination clearly, and see their states in relationship to each other.</p>
	<p>You can select any two particles in a state and set them as the selected particles. If 'active' is not checked they won't be available for selected particle operations. Placemark particles can also be used as selected particles, although they themselves cannot have trails, since they aren't allowed to move.</p>
	<h4>Show Selected Particle Glyphs</h4>
	<p>When checked, this will display a small animated indicator connected to selected particles by a short line and sharing its colour. This indicator is again intended to help make the selected particles stand out. In the image below the selected particles are Earth and Asteroid 99942 Apophis.</p>
	<img src="images/glyphs.png" alt= "selected particle indicators"></img>
	<h4>Draw Line between Selected Particles</h4>
	<p>This is intended to make it easier to demonstrate visually the relative distance between the two selected particles.</p>
	<img src="images/connectingLine.png" alt= "selected particle connecting line"></img>
	<h4>Show Distance between Selected Particles</h4>
	<p>Using this you can get a measure in either KM or AU of the distance between your selected particles shown in the console</p>
	<h4>Show State Vector</h4>
	<p>This will display the position and velocity for the selected particles</p>
	<h4>Show Relative Velocity</h4>
	<p>This shows the velocities of the two selected particles relative to each other. This is meant to allow the demonstration of flyby velocity.</p>
	<h4>Trails</h4>
	<p>Particles can have trails if you want, or just the selected particles. They are off by default. Trails are expensive in terms of memory, so bear in mind that if you have a great many particles, trails that are too long might not be a good idea. There is no hard limit as to allowed trail size yet, so I suggest you experiment to see how many work well for a given dataset. I will post some more exact recommendations in the future.</p>
	<p>You can opt to turn off all trails except those for the selected particles. This is meant as an aid to presentation, allowing the motion of the two particles to be more clearly seen.</p>
	<h4>Particle Display</h4>
	<p>You can choose to display the particles as spheres, little markers, or single pixels. For very large numbers of particles, for example the particle count one would find in a plummer model (1000+), you may want to use markers or single pixels to represent particles, since this will increase rendering speed and may well be better suited to displaying clusters.</p>
	<img src="images/displayTypes.png" alt= "Jupiter"></img>
<a href="#top" style="font-weight: bold;">Back To Top</a>
</div>
<?php
include("includes/footer.php");
?>
