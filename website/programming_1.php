<?php
session_start();
include("includes/header.php");
include("menu.php");
?>
<div id="content">
<h2>Building a basic n-Body Model using Moody</h2>
<p>There's a lot you can do with Moody, but to start with we'll do something basic to introduce the software. We'll use Moody to create a simple n-body model that will iterate for 100 states (sidereal days in this case) using the Reference Project.</p>
<p>On Windows you will need to use Visual Studio 10, but on other platforms it's up to you what you use. I use codeblocks for the moment, but that's not required.</p>
<div class = "horizontalDivider"></div>
<h3>Step 1: Adding Moody to your project</h3>
<p>Include Moodys header in the main cpp file of your own project (note: the file moody.cpp is there simply to allow you to compile the demo version, you should either erase and replace it's content or delete it if you want to use moody).</p>
<div class = "codeblock">
	<pre class="hl">
	<span class="hl ppc">#include</span> <span class="hl pps">&quot;moody/moody.h&quot;</span>
	</pre>
</div>

<h3>Step 2: set up the Parallisation API</h3>
<p>Read the file Moody_demo.cpp. Some sections of it are surrounded by #ifdef blocks, for example:</p>
<div class = "codeblock">
	<pre class="hl">
		<span class="hl ppc">#ifdef OMPLIB</span>
			std<span class="hl opt">::</span>cout <span class="hl opt">&lt;&lt;</span> <span class="hl str">&quot;&gt; OpenMP API In Use&quot;</span> <span class="hl opt">&lt;&lt;</span> std<span class="hl opt">::</span>endl<span class="hl opt">;</span>
		<span class="hl ppc">#endif</span>
		<span class="hl ppc">#ifdef TBBLIB</span>
			std<span class="hl opt">::</span>cout <span class="hl opt">&lt;&lt;</span> <span class="hl str">&quot;&gt; Intel Thread Building Blocks Template Library In Use&quot;</span> <span class="hl opt">&lt;&lt;</span> std<span class="hl opt">::</span>endl<span class="hl opt">;</span>
			tbb<span class="hl opt">::</span>task_scheduler_init automatic<span class="hl opt">;</span>
		<span class="hl ppc">#endif</span>
	</pre>
</div>
<p>This is used to determine which blocks of code are compiled, depending on which parallelisation API is being used. The example above is fairly trivial, the only important effect is that the tbb scheduler will not be initilaised if Thread Building Blocks is not in use. If situations arise in your own code where there may be different bahaviours or requirements with each available API, then I suggest you use this aproach.</p>
<p>If you only ever intend to use one of the available concurrency libraries you can avoid using the #ifdef blocks altogether.</p>
<p>We are going to use Thread Building Blocks (TBB), so we use the #ifdef block to enclose the initialisation. If you later decide to use OpenMP instead, you don't have to change this.</p>
<div class = "codeblock">
	<pre class="hl">
		<span class="hl ppc">#ifdef TBBLIB</span>
			std<span class="hl opt">::</span>cout <span class="hl opt">&lt;&lt;</span> <span class="hl str">&quot;&gt; Intel Thread Building Blocks Template Library In Use&quot;</span> <span class="hl opt">&lt;&lt;</span> std<span class="hl opt">::</span>endl<span class="hl opt">;</span>
			tbb<span class="hl opt">::</span>task_scheduler_init automatic<span class="hl opt">;</span>
		<span class="hl ppc">#endif</span>
	</pre>
</div>

<p>Actually, in the newer versions of TBB this step isn't required, but leaving it out would cause problems on systems that still have an older build, so its best kept in your code. Now we need to create the Capsule we're going to use, which is an instance of the standard Capsule Class that comes with Moody. This Capsule class is itself empty, all its methods and members are inherited, therefore this is the place where all your own new code would go. This time round we aren't going to add any new code, we're just going to use the existing functionality. </p>
<div class = "codeblock">
	<pre class="hl">
		Capsule <span class="hl opt">*</span> experiment <span class="hl opt">=</span> <span class="hl kwa">new</span> Capsule<span class="hl opt">;</span>
		experiment<span class="hl opt">-&gt;</span><span class="hl kwd">loadProject</span><span class="hl opt">(</span>argv<span class="hl opt">[</span><span class="hl num">1</span><span class="hl opt">]);</span>	</pre>
</div>
<p>Note that the parameter given for loadProject is <b>argv[1]</b>. This is because the location of the project is going to be provided as a command line parameter</p>  
<p>Most of the information for the particles is provided in the project, but we can also give the particles some internal memory. This is used when a particle is calculating its motion. For example the Runge Kutta forth order integrator that comes with Moody needs a particle to be able to remember 4 previous states during integration, so we set that by doing the folllowing</p>
<div class = "codeblock">
	<pre class="hl">
	experiment<span class="hl opt">-&gt;</span><span class="hl kwd">createParticleMemory</span><span class="hl opt">(</span><span class="hl num">4</span><span class="hl opt">);</span>
	</pre>
</div>

<p>The Runge-Kutta integrator is the most accurate, and thus slowest Integrator available in Moody. There is also a 2nd Order Symplectic integrator and 2nd Order Midpoint integrator, both of which are much faster. The Symplectic Integrator does not require particle memory, while the Midpoint integrator requires particle memory set to 2. See moody_demo.cpp for example code on their use.</p>
<p> A call to any integrator using the iterate[integrator tyype] method will cause it to integrate for one step</p>
<div class = "codeblock">
	<pre class="hl">
	experiment<span class="hl opt">-&gt;</span><span class="hl kwd">iterateRK4</span><span class="hl opt">(</span><span class="hl opt">);</span>
	</pre>
</div>
<p>Moody times simulations by using states and steps. These are specified in the cfg.xl file in the project folder, in the reference project. The entries in that file are</p>

<div class = "codeblock">
	<pre class="hl">
	<span class="hl kwa">&lt;G&gt;</span><span class="hl num">6.674040E-11</span><span class="hl kwa">&lt;/G&gt;</span>
	<span class="hl kwa">&lt;states&gt;</span><span class="hl num">5000</span><span class="hl kwa">&lt;/states&gt;</span>
	<span class="hl kwa">&lt;steps&gt;</span><span class="hl num">1440</span><span class="hl kwa">&lt;/steps&gt;</span>
	<span class="hl kwa">&lt;stepSize&gt;</span><span class="hl num">60</span><span class="hl kwa">&lt;/stepSize&gt;</span>
	<span class="hl kwa">&lt;version&gt;</span><span class="hl num">1.0</span><span class="hl kwa">&lt;/version&gt;</span>
	<span class="hl kwa">&lt;MopName&gt;</span>Reference_Project<span class="hl kwa">&lt;/MopName&gt;</span>
	</pre>
</div>


<p>We can override any of these values once a project has been loaded into a capsule. This is done by creating a new CapsuleSettingsStore struct and filling in the values. Or exporting the current settings, changing the ones we want and re-importing the revised settings. We'll cover this shortly.</p>

<p>Stepsize in this case is a measure in seconds, so in this case the integrator will advance a particle for one minutes worth of motion in a single step. We don't want to change that now so we'll be using the stored value which is used directly by the integrator.</p>

<p>The number of Steps is 1440. That would be a whole days worth of motion, so that's fine, we'll keep it. To access it we call experiment->getNumSteps()</p>

<p>The number of states in the cfg file is higher than we want for this example, so instead of using it, which we would do by calling experiment->getNumStates(), we can either change the stored value to 100 or just use the value 100 directly. For now that's what we'll do.</p>

<p>Moody has some basic timing functionality built in, so you can get a total runtime for an experiment. Starting and stopping the timer is done using the following capsule methods</p>
<div class = "codeblock">
	<pre class="hl">
	experiment<span class="hl opt">-&gt;</span>timer<span class="hl opt">.</span><span class="hl kwd">start</span><span class="hl opt">();</span>

	experiment<span class="hl opt">-&gt;</span>timer<span class="hl opt">.</span><span class="hl kwd">stop</span><span class="hl opt">();</span>
	</pre>
</div>
<p>We also want to keep a record of the time series generated, so we need to set that up. The name that will be used for the Mop file that stores the time series outpput of Moody is set in the cfg file, we can over-ride it easily enough, but here we'll use it.</p>

<div class = "codeblock">
	<pre class="hl">
	createMopFile</span><span class="hl opt">(</span>experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getResultFolder</span><span class="hl opt">(),</span>experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getMopName</span><span class="hl opt">());</span> 
	</pre>
</div>


<p>Ok, that's all the peices we need, so we can go ahead and code up the model.</p>
<div class = "codeblock">
<pre class="hl">
<span class="hl ppc">#include</span> <span class="hl pps">&quot;moody/moody.h&quot;</span><span class="hl ppc"> </span>
<span class="hl kwb">int</span> <span class="hl kwd">main</span><span class="hl opt">(</span><span class="hl kwb">int</span> argc<span class="hl opt">,</span> <span class="hl kwb">char</span> <span class="hl opt">*</span>argv<span class="hl opt">[]) {</span>
        <span class="hl ppc">#ifdef TBBLIB</span>
			std<span class="hl opt">::</span>cout <span class="hl opt">&lt;&lt;</span> <span class="hl str">&quot;&gt; Intel Thread Building Blocks Template Library In Use&quot;</span> <span class="hl opt">&lt;&lt;</span> std<span class="hl opt">::</span>endl<span class="hl opt">;</span>
			tbb<span class="hl opt">::</span>task_scheduler_init automatic<span class="hl opt">;</span>
	<span class="hl ppc">#endif</span>
        Capsule <span class="hl opt">*</span> experiment <span class="hl opt">=</span> <span class="hl kwa">new</span> Capsule<span class="hl opt">;</span> 
	experiment<span class="hl opt">-&gt;</span><span class="hl kwd">loadProject</span><span class="hl opt">(</span>argv<span class="hl opt">[</span><span class="hl opt">]);</span>	
        experiment<span class="hl opt">-&gt;</span><span class="hl kwd">createParticleMemory</span><span class="hl opt">(</span><span class="hl num">4</span><span class="hl opt">);</span> 
        experiment<span class="hl opt">-&gt;</span><span class="hl kwd">createMopFile</span><span class="hl opt">(</span>experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getResultFolder</span><span class="hl opt">(),</span>experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getMopName</span><span class="hl opt">());</span> 
        experiment<span class="hl opt">-&gt;</span>timer<span class="hl opt">.</span><span class="hl kwd">start</span><span class="hl opt">();</span> 
        <span class="hl kwa">for</span> <span class="hl opt">(</span><span class="hl kwb">int</span> i <span class="hl opt">=</span> <span class="hl num">0</span><span class="hl opt">;</span> i<span class="hl opt">&lt;</span><span class="hl num">100</span><span class="hl opt">;</span>i<span class="hl opt">++) {</span>
                <span class="hl kwa">for</span> <span class="hl opt">(</span><span class="hl kwb">int</span> j<span class="hl opt">=</span><span class="hl num">0</span><span class="hl opt">;</span>j<span class="hl opt">&lt;</span>experiment<span class="hl opt">-&gt;</span><span class="hl kwd">getNumSteps</span><span class="hl opt">();</span>j<span class="hl opt">++) {</span>
                        experiment<span class="hl opt">-&gt;</span><span class="hl kwd">iterateRK4</span><span class="hl opt">(</span><span class="hl opt">);</span> 
                <span class="hl opt">}</span> 
		experiment<span class="hl opt">-&gt;</span><span class="hl kwd">writeCurrentStateToMopFile</span><span class="hl opt">();</span>       
	<span class="hl opt">}</span> 
        experiment<span class="hl opt">-&gt;</span>timer<span class="hl opt">.</span><span class="hl kwd">stop</span><span class="hl opt">();</span> 
<span class="hl opt">}</span>
</pre>
</div>

<p>And that's it. The model will iterate for 100 days worth of motion, recording it as a mopfile with 100 states and writing the time taken to stdout.</p>
<div class = "horizontalDivider"></div>
<p>Actually, the choice of Runge Kutta wasn't really good in this instance, since a number of the moons in the reference project cannot yet maintain stable orbits over time when that integrator is in use, we only used it so you would need to use the particles memory (try running your model for 1000 steps and watch the results in MopViewer, the orbits of some moons will degrade rapidly). In fact the best choice would be the Symplectic Integrator. </p>
<div class = "codeblock">
	<pre class="hl">
	experiment<span class="hl opt">-&gt;</span><span class="hl kwd">iterateSym</span><span class="hl opt">(</span><span class="hl opt">);</span>
	</pre>
</div>
<p>As mentioned above, the Symplectic Integrator doesn't need to have the particle remember previous states, so if you use that the call</p>
<div class = "codeblock">
	<pre class="hl">
	experiment<span class="hl opt">-&gt;</span><span class="hl kwd">createParticleMemory</span><span class="hl opt">(</span><span class="hl num">4</span><span class="hl opt">);</span>
	</pre>
</div>
<p>can be omitted from your code.</p>
	<a href="#top" style = "font-weight: bold; text-decoration: underline;">Back To Top</a>
</div>
<?php
include("includes/footer.php");
?>
