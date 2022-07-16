<?php
session_start();
include("includes/header.php");
include("menu.php");
?>
<div id="content">
<h2>The Integrators available in Moody</h2>
<p>Moody has three integrators, each of which are parallel and will scale to fit the number of processors available. Which to use depends on the needs of your experiment. Versions of each are provided for both OpenMP and Thread Building Blocks. Method calls are the same for whichever parallelisation aproach is in use. </p>
<h3>Fourth Order Runge-Kutta</h3>
<p>This is an implementation of the algorithm described in Numerical Recipes in C (Teukolsky et al).</p>
<div class = "codeblock">
<pre class="hl">	
	<span class="hl kwb">void</span> <span class="hl kwd">iterateRK4</span><span class="hl opt">(</span><span class="hl opt">);</span>
</pre>
</div>
<h4>When to use</h4>
<p>Runge-Kutta is the most accurate integrator included with Moody. That accuracy deteriorates over time as error accumulates, so this integrator is best used for situations where short term accuracy is important.</p>
<h3>Second Order Midpoint</h3>
<p>Again this is the method described in Numerical Recipes.</p>
<div class = "codeblock">
<pre class="hl">	
	<span class="hl kwb">void</span> <span class="hl kwd">iterateMidPoint</span><span class="hl opt">(</span><span class="hl opt">);</span>
</pre>
</div>
<h4>When to use</h4>
<p>Midpoint is the least accurate integrator included with Moody. This integrator is best used for situations where accuracy is less important than speed of calculation. </p>
<h3>Second Order Symplectic Integrator (leapfrog)</h3>
<div class = "codeblock">
<pre class="hl">	
	<span class="hl kwb">void</span> <span class="hl kwd">iterateSym</span><span class="hl opt">(</span><span class="hl opt">);</span>
</pre>
</div>
<h4>When to use</h4>
<p>The Symplectic Integrator is only 2nd order accurate, but it has the advantages of being both stable and time reversible. This integrator should be used when long term orbit stability is important for your experiment.</p>
<a href="#top" style = "font-weight: bold; text-decoration: underline;">Back To Top</a>
</div>
<?php
include("includes/footer.php");
?>
