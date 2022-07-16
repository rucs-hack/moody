<?php
session_start();
include("includes/header.php");
include("menu.php");
?>
<div id="content">

	<h2>The Moody Reference Project</h2>

	<p>The reference project is an ongoing attempt to create a model of the Solar System. At present the starting conditions are those for the 24th of august 2008. The project configuration is set to model 500 days of motion in steps of 60 seconds.</p>


	<p>Current Release version 1.8</p>

	<p>The dataset currently contains all the Planets, twenty Moons, three Near Earth Asteroids, 38 Main Belt Asteroids, one Comet and the Voyager and Pioneer Spacecraft. There are also three non interactive placemarker particles, one on each axis at one AU distance from Sol.</p>
	<p>Particle sizes when displayed in MopViewer are not to scale. I've selected the current scale so as to make the particles easily visible.</p>

	<p>New moons and other objects are being added as and when I get them working in the model. Some masses are aproximations, so a later stage of this effort will be to refine those experimentally.</p>
	<p>The orbits of many of the Moons present are only stable when the symplectic integrator is used.</p>
	<h3>List of Solar System Objects included in the Reference Project</h3>
	<h4>Major Bodies</h4>

	<ul class = "generalList">
		<li>Sol</li>
		
		<li>Mercury</li>

		<li>Venus</li> 

		<li>Earth</li>

		<li>Mars</li>

		<li>Jupiter</li> 

		<li>Saturn</li>

		<li>Uranus</li>

		<li>Neptune</li>
	</ul>

	<h4>Moons</h4>

	<ul class = "generalList">
		<li>Luna</li>
				
		<li>Phobos</li> 
		
		<li>Deimos</li> 
		
		<li>Europa</li> 
		
		<li>Io</li> 
		
		<li>Ganymede</li> 

		<li>Callisto</li>
		
		<li>Mimas</li>
		
		<li>Enceladus</li>
		
		<li>Tethys</li>
		
		<li>Dione</li>
		
		<li>Rhea</li>
		
		<li>Titan</li>
		
		<li>Iapetus</li>
		
		<li>Ariel</li>
		
		<li>Umbriel</li>
		
		<li>Titania</li>
		
		<li>Oberon</li>

		<li>Miranda</li>
		   
		<li>Triton</li>
	</ul>
	<h4>Near-Earth Asteroids</h4>

	<ul class = "generalList">
		<li>Apophis</li> 

		<li>Eros </li>

		<li>Itokawa</li> 
	</ul>

	<h4>Main Belt Asteroids</h4>

	<ul class = "generalList">
		<li>Ida </li>

		<li>Ceres</li> 

		<li>Pallas</li> 

		<li>Juno </li>

		<li>Vesta </li>

		<li>Astraea </li>

		<li>Hebe </li>

		<li>Iris </li>

		<li>Flora </li>

		<li>Metis </li>

		<li>Hygiea </li>

		<li>Parthenope </li>

		<li>Victoria </li>

		<li>Irene </li>

		<li>Eunomia </li>

		<li>Psyche </li>

		<li>Thetis </li>

		<li>Melpomene </li>

		<li>Fortuna </li>

		<li>Massalia </li>

		<li>Lutetia </li>

		<li>Kalliope </li>

		<li>Thalia </li>

		<li>Themis </li>

		<li>Phocaea </li>

		<li>Proserpina </li>

		<li>Euterpe </li>

		<li>Bellona </li>

		<li>Amphitrite </li>

		<li>Urania </li>

		<li>Euphrosyne </li>

		<li>Pomona</li> 

		<li>Circe</li> 

		<li>Leukothea</li> 

		<li>Atalante</li> 

		<li>Fides</li> 

		<li>Ganymed</li> 

		<li>Cybele</li> 
	</ul>
	<h4>Comets</h4>

	<ul class = "generalList">
		<li>Comet 1P/Halley</li>
	</ul>
	<h4>Spacecraft</h4>

	<ul class = "generalList">
		<li>Voyager 1</li>

		<li>Voyager 2</li> 

		<li>Pioneer 10</li>

		<li>Pioneer 11</li> 
	</ul>

	<h3>Sources of Data for the Reference Project</h3>

	<p>The data used in the reference project was obtained via the	<a href="http://ssd.jpl.nasa.gov/horizons.cgi" target="_blank" style = "font-weight: bold; text-decoration: underline;">JPL Horizons Ephemeris database</a>. </p>
    <p>In some cases Wikipedia has also been used to gather some of the additional data required.</p>
	<p>While the Reference Project is a model of our Solar System, Moody can model any system of particles, so particle data can be generated in any way that suits your needs. I will be adding some particle system generator functionality to Moody in the future.</p>


			
	<a href="#top" style = "font-weight: bold; text-decoration: underline;">Back To Top</a>
</div>
<?php
include("includes/footer.php");
?>
