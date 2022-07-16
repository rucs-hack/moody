<?php
session_start();
include("includes/header.php");
include("menu.php");
?>
<div id="content">
<h2>An Introduction to Evolutionary algorithms</h2>

<p>Before we get into how to perform evolutionary computation experiments using Moody, we need an introduction to the concept of evolutionary algorithms. Therefore I've reproduced the following text from my doctoral thesis.</p>
<p>This is a broad survey of the topic, and should be sufficient to prepare you for the rest of the tutorials, where specific methods used will be described in more detail. None of this text refers specifically to Moody or orbital mechanics, but that's not required.</p>
	<div class = "horizontalDivider"></div>
<p>
Evolutionary algorithms (EAs) are optimization methods loosely based on the mechanics of natural selection and genetics. Evolutionary algorithms are a form of stochastic (random, as opposed to deterministic)  search method, that have come to prominence in the last few decades as an efficient means of finding either exact or approximate solutions to complex optimisation problems. The more complex the problem, or the more dimensions it encompasses, the more likely it is that the solution will be an approximation, as it may not be possible to locate a single exact solution.
</p>
<p>
Optimisation problems can be cast as existing in two types. There are those which can be solved by constructing the solution in a series of iterative steps in a reasonable time, and those for which no algorithm to locate the exact solution is known, or the time taken by a known method such as an iterative search would simply be too great to consider.
</p>
<p>
There are two broad classes of problems that EAs and other search methods may be applied to, known as problems in P or NP. These require some definition. P stands for Polynomial (time), and in the current context refers to the set of problems that can be solved in polynomial time on a deterministic Turing machine. In essence problems in P, while they may be complex, are such that an algorithm can be constructed that will solve the problem in a series of steps.  A suitable example is searching through the Dewey system cards in a library. Under the Dewey system books are organised by author and category. Thus to find the location of a book in a box of index cards, you would locate the relevant drawer, select a card, establish whether it is ‘above’ or ‘below’ the required book in the system, and sample another card in the indicated direction. By following this process,  you are assured of finding the exact book you require, with time taken being dependant on the number of cards that must be searched. Provided the book exists, and the number of cards is manageable, the same, iterative approach remains effective in locating the single possible solution.
</p>
<p>
NP stands for Non Deterministic Polynomial (time). NP is the set of  problems solvable in polynomial time by a non-deterministic Turing machine. NP also contains all the problems in P. Within NP there are problems which are considered hard, known as NP-complete If a problem is NP-complete then it is likely to be in the class of problems for which a stochastic approach is going to be suitable. The Travelling Salesman Problem, whereby a salesman must visit all the cities on his itinerary only once and using as short a route as possible is an example of a problem in NP which, while in the trivial case of just a few cities can be solved using a simple iterative process which will halt in reasonable time, moves into being NP-complete once you introduce a large number of cities, such as for example, all cities in the UK. While in theory the problem could still be solved using an iterative process of elimination, by examining all possible routes between cities in the UK, this process cannot be completed in reasonable time. Nor can it be known whether or not there is a single best solution to locate, so all possible solutions would need to be examined before the best solution found could be announced. In such a situation a stochastic method, such as an evolutionary algorithm, can be used to locate a solution which may not be optimal, but may still be useful, in reasonable time.
</p>
<p>

Evolutionary algorithms seek to define the problem they are intended to solve by mapping them into a phenotype, that is, the visible or measurable characteristics of the problem, then defining the genotype, or the characteristics that make up an individual representation of that problem. Individual instantiations of this that will be subjected to evolution are referred to as chromosomes. The components of the chromosome are referred to as genes, and each possible value of a gene is an allele, and it is these which are subjected to mutation within the chromosome.
</p>
<p>
Mapping the problem into a form suitable for manipulation by an EA of necessity involves some simplification. This carries the risk of making the representation too coarse to be applied back to the original problem. Therefore care is needed to ensure that no significant parameters are removed when encoding the problem, whilst simultaneously simplifying the problem to the point that a workable representation is found. This representation is then manipulated by the evolutionary algorithm using one of a number of strategies available. This manipulation takes the form of mutation, or random changes to an individual chromosome, or recombination, which involves taking elements of existing chromosomes and recombining them to form new individuals.
</p>
<p>
One method by which this manipulation is achieved known as Stochastic Hill-Climbing (SHC) [1]. A single chromosome is created and evaluated by a fitness function, being assigned a fitness value according to how well it does on the task at hand. Then a random change is made to that individual. If this mutated individual has a better performance, it replaces the parent chromosome and the process is repeated. Termination of SHC occurs when either a set number of iterations have been completed, or a sufficient number of iterations have passed without further improvement. At this point the chromosome has reached a point where it cannot improve further, and represents the best answer obtainable on this occasion.
</p>
<p>
This simple method has drawbacks. The name Stochastic Hill Climbing reveals that the landscape of the problem is composed of (or perhaps, best thought of as) a series of hills, more correctly referred to as local and global optima. The Global Optimum is that point in the solution space that corresponds to the optimal solution, or the region in which the best possible solutions can be found (there may be many equivalent such solutions). However once SHC starts up the first optima it locates, the simple progression method it uses means that it easily becomes trapped in a local optima and unable to reach the ideal global optima.
</p>
<p>
Solutions exist for this problem. The easiest to implement is Multi-start SHC. In this, chromosomes are started at several randomly assigned points on the landscape. By this method it is hoped that at least one of the chromosomes will reach the desired Global Optima. Another method is Simulated Annealing (SA) (Kirkpatrick et al, 1983) [1], (Metropolis et al 1958) [2]. This method takes its name from the metallurgical process of annealing because it mimics the process undergone by misplaced atoms in a metal when its heated and then slowly cooled. These atoms are initially extremely mobile, with that ability to shift position reducing as cooling progresses.
</p>
<p>
Simulated annealing allows mutations which have caused a chromosome to become less fit to persist when SHC would have discarded them. This causes the chromosome to ‘jump around’ the problem landscape, greatly expanding the area that a chromosome can cover whilst evolving. In practice this means that a chromosome which is moving up the ‘hillside’ of a local optimum is likely to be shifted, or ‘knocked off’ that local optimum if it is too small for the cooling jump to keep the chromosome in its vicinity. The cooling term reduces over time, allowing for fewer and fewer random jumps. As the chromosome approaches a global optimum, which is by virtue of its superiority in the search space a steeper hill than the local optima, these jumps are less likely to knock it off the slope, and it can progress as far up the global optima as possible. Problem landscapes are rarely smooth, so it is still unlikely to reach the most optimal solution in all cases, but it can be reasonably assumed to get close enough for a useful solution to be found. In practice cooling is often halted before SA completes, giving the chromosome some time to evolve along the by now fixed path of ascent without interruption using just SHC. SHC, in spite of its drawbacks, is considered an excellent starting point when initially working on a problem with EAs. SHC results not only provide reasonable answers, they can do so quickly, and provide a benchmark for evaluating the later performance of more complex methods.
</p>

<h3>Population based methods</h3>
<p>
A method directly borrowed from nature in order to provide a more complex evolutionary environment is to use populations of chromosomes engaged in competition to become the superior member of the population. Superiority provides either the automatic ability to breed, or places a chromosome in the position of being more likely to breed.
</p>
<p>
The three primary population based methods are the <b>static</b>, <b>generational</b> and <b>island</b> models.
</p>
<p>
In the <b>static</b>, or <b>steady state</b> model, the population is gradually improved by producing superior chromosomes within that population and over-writing the least well performing members of that population.

</p>
<p>
In <b>generational</b>, the members of generation <i>t</i> are mutated through use of mutation and recombination to produce generation <i>t+1</i>, with each new generation moving towards the optimal solution.
</p>
<p>
In the <b>island model</b>, separate populations of chromosomes are evolved, using either of the above methods in each population. This allows each population to evolve distinct from the other populations. Depending on level of diversity sought, there are two methods of interaction between the islands. In the simplest there is no interaction. Each island evolves its population separately using the same survival criteria as the other Islands. In the second, members of the population on each island are periodically moved across to other islands, introducing mixing and thus seeking to avoid over-specialisation in any one population. The winning chromosome then becomes either a set comprised of one from each population, or a single chromosome taken to be the best overall between the several islands being evolved.
</p>
<h3>Variation Operators</h3>

<p>
At the beginning of an EA, the chromosomes are initialized either in a completely random manner, or with random variations of a prepared state. The general idea being to ensure they are well spread about in the search space. Usually there is no requirement that the locations they inhabit represent good solutions, only that the chromosomes are distant from each other. In order to move from this state, which is assumed to be very poor at performing the task, to one more closely matching the desired state, chromosomes must be changed in some way. This change can be achieved in several ways.
</p>
<h4>Simple mutation</h4>
<p>
The idea here is that we will just change the chromosome a very small amount. For example, considering a chromosome which is a vector of real values this means generating a small real value number using the standard distribution, and applying it to an allele in the chromosome.
</p>
<h4>Replacement mutation</h4>
<p>
There are several basic forms of replacement. Either a single allele is completely replaced, or a significant part of or all the chromosome is completely replaced. This is quite a strong mutation; one more likely to produce good results early in the progress of the EA
</p>
<h4>n point crossover</h4>
<p>
In the basic form of crossover, two chromosomes are selected, a split point (some position along the chromosome) is selected, and a new chromosome is created using the portion from one parent chromosome from before this split point, and the portion of the other parent which occurs after this split point. The number of split points can be increased to any number reasonable given the size of the chromosome. As each split point is reached, the donating parent changes back and forth, so the more split points, the greater the mixing of the resultant offspring chromosome.
</p>
<h3>Selection</h3>
<p>

In order for evolution to progress satisfactorily, some form of selection pressure must be placed on a population. This simulates the operation of environmental pressures and intra species competition to become the dominant member of that population. Two such methods are rank based or fitness proportional selection, and tournament selection. In rank based, which is also known as elitist selection, members of the population are ordered by fitness, and assigned a probability of selection. This ordering is either individual, so that every member of the population is assigned an individual selection probability, or grouped, so that members of the population with a similar fitness (as decided by some uniform division of existing fitness measures) are assigned probabilities in common. Using this method the probability that a poorly performing chromosome will get to reproduce through mutation or crossover is reduced, but not eliminated. In Tournament selection, a tournament size is defined, and that number of members of the population is selected. Then the fitness values of the tournament group are compared, and the member of the tournament group with the greatest fitness is chosen for mutation. Thus any reasonably performing member of the population has a chance to reproduce provided it is superior to those other members of the tournament group. Tournament size can vary; though tend to be small when compared to overall population size. Binary tournament is common; with just two members of the population used, but greater tournament sizes can be chosen to increase selection pressure on the population. In both cases  the aim is to allow the mutation which result in superior chromosomes to survive and replace inferior chromosomes in either the current population, or form part of the next generation. Another selection method, used primarily when population diversity or overly rapid convergence is an issue, is Crowding.
</p>
<p>
Crowding involves selecting a group of chromosomes from a population, finding the average performance of that group, and then measuring how each individual member of the group differs from that average. The chromosome which is found to differ least from the average configuration is selected for mutation. This method rewards chromosomes for being similar to the rest of the chromosomes in the population by making it more likely that they will be selected for mutation. The result is a population that is ‘crowded’ together, with members of the populations remaining fairly similar to each other in terms of performance. Such a population is very slow to evolve, since rapid departure of one chromosome from the others is less likely to result in its continued survival. Crowding does not prevent one chromosome from becoming superior over time, but the slowing goes some way to ensuring that more chromosomes get a chance to improve and become the dominant chromosome.
</p>
<h3>Train, Test, Validate</h3>
<p>
Careful and considered management of the available data needs to be used when an EA (or any method at all) is applied to a machine learning problem – i.e. the problem is to find a good predictive model for a particular dataset. In such a case, whether an EA is used or any machine learning method is used, the data used consists usually of two sets. These can be called the positive set, and the negative set. These sets consist of those samples of the data which contain, and those that do not contain, the feature that the chromosomes are being trained to recognize. The negative set, or ‘control’ should belong to the same overall class as the positive set, but lack the feature of interest. These two classes are each subdivided into two sets, being the training set, and the testing set. Each of these sets contain examples of the positive and negative classes. On occasion, dependent on the particular experiment, the two classes are split into three sets, being training testing and validation sets
</p>
<p>
When the train and test sets are used, as their names imply, the chromosome/population of chromosomes (from now on we will simply refer to a population) are first optimized to perform their feature recognition task on the training set, and their performance on this task is evaluated against the testing set. Here there are two possibilities for deciding that the chromosomes have reached their probable best performance in a given experiment. First we can wait until the evolutionary forces acting on the population (mutation, selection pressure) are no longer succeeding in generating superior solutions, perhaps with a pre-defined time limit, such as a certain number of unsuccessful mutations occurring, and choose this point to output an evaluation result against the testing set (Note that the result against the training set is hopelessly optimistic (Witten [3]) and cannot be used).
</p>
<p>
This method is rather simplistic, and generally applied only when the populations converge quickly and cease to produce successful mutations in a short time. This situation is generally avoided, since rapid convergence is not usually likely to produce good results. Strategies such as the use of the Island population model and application of crowding when selecting chromosomes for mutation are among the methods applied to avoid this situation.  Secondly, we can apply the testing set frequently during the training process. Perhaps each time a mutation has produced a superior chromosome, or at a fixed interval during the training process. We then gain the ability to discover the point of best performance against the testing set, which may not be the point of convergence against the training set. This is a more useful measure of performance, since the performance measure we obtain is that of the chromosomes/the winning chromosome against a set that it did not encounter during the training process.
</p>
<p>
This method does have a disadvantage. By deciding through use of the testing set that the point of best performance has been reached, and then producing a result against that testing set as our final output, we are obtaining a result which is somewhat closely bound to the training process, even though the testing set cannot play a part in the evolution process. Our testing set is, if you like, the thing we use to decide that evolution has concluded, or has found a suitable result. If we then use it to produce our final output, even though the testing set is unseen during the training process, we are producing a result which is directly representative of the good result that halted evolution. This might not sound like much of a problem, and indeed there are cases when this is entirely sufficient. However, to produce a more objective result, we need to introduce a third set, the validation set [4] [3].

</p>
<p>
The validation set, as with the training and testing sets, consists of members of the positive and negative classes of data (and contains no members also present in either the training or testing sets). This set replaces the testing set in the task of deciding convergence. Now, instead of checking the evolving chromosome/s against the testing set and recording the result as the final answer, we apply the evolving chromosomes to the validation set instead. If convergence is detected/suspected based on performance against this validation set, the chromosomes/s in question are applied to the testing set, and that result is the one recorded as the final answer.
</p>
<p>
By doing this we are almost certain to get a result which is less good than if we used the set which decided that the point of convergence had been reached. Instead we obtain an answer from a set which played no part in either training or performance checking. Such a result is far more likely to be representative of the performance of the evolved chromosome/s in the general case, which is of far greater interest, particularly with machine learning problems.
</p>
<h3>Cross Validation</h3>
<p>
If there is lots of data available that contains the required features/patterns, then a single instance of the training, test and validation sets can be used. However, as is more often the case with data that has already been partitioned into classes, or ‘labelled’ tend to be in limited supply [3]. An example of a labelled dataset is one we use in this thesis, containing examples of particular conserved sequences in DNA, and control data that is known to have none of those features (the negative set) , that was created specifically for the task of evolving feature detectors. There are vastly more data available that have not been so labelled.
</p>
<p>
Given then that the labelled data available is likely to be small in number, perhaps even a single dataset of the type required, if you use a single training and testing set with or without validation, you can find it difficult to properly evaluate the performance of your evolved classifier. To solve this problem we can apply another technique of machine learning, called k fold cross validation.  With this, the dataset is partitioned k times, giving k subsets, each of which becomes a testing set. For each of these testing sets we take the remainder of the dataset and use that as the training set. In this way we can conduct k experiments, or folds, none of which will use the same data in the testing process, and we can average the results of all folds to produce the final performance measure for the classifiers/feature detectors we are evolving. Should a validation set be required, this can be separated from the main dataset before the k testing sets are created.
</p>

<h3>Objectives, defining the desired outcome</h3>
<p>
Evolutionary algorithms make use of an objective function (or multiple objective functions in the case of multi-objective optimisation) to guide the search process. The basic aim of an objective function is to select superior chromosomes over inferior ones and allow the superior to survive. The objective function must replicate the task that the evolved chromosome is going to be expected to perform, apply the chromosome to that task, and award a score based on its performance of the task. This is normally a measure of error, being the amount in which the actual performance of the chromosome differed from the desired performance. This desired performance can either be a known value, where you have a specific goal in mind, or a simple requirement to do as well as possible on a task that has no known ‘best’ performance measure. In feature detectors the latter is usually the case. It might also be, for example, that the chromosome is a flight plan for a spacecraft, and the objective function has a specific goal in mind, e.g. a location in space, but is looking to find the chromosome that uses the least fuel, or takes the least time given a set amount of fuel allowed.
</p>
<p>
An important element of any objective function are constraints. These are the limits within which the objective function must operate. To take the example of the spacecraft, you might constrain its optimisation of say, a journey from Earth to mars by saying something like ‘the spacecraft may not pass through a planet during the journey’, or ‘the spacecraft must complete the journey within n days’. Trivial perhaps, but without such constraints the objective function may allow chromosomes to survive whose results are either invalid on final inspection or take far too long to complete the task at hand.  In a more usual situation a constraint might be, for a chromosome that represents the positioning of components on a chip, that certain components must be a certain distance from each other. This could either be implemented as a hard rule ‘distance between components a and b must be greater then x’, or by assigning a portion of the fitness based on the distance managed.
</p>
<p>
Ultimately there are as many objective functions as there are problems to be solved. They usually fall into one of the two classes we mentioned, that of being single or multi objective in nature. A single objective function combines all aspects of the chromosome’s performance (its actual objectives) into a single value, a multi objective function keeps these parameters separate. These will now be covered in more detail.
</p>
<h4>Single Objective Optimisation</h4>
<p>
The Single Objective method involves composing the answer to a given optimisation problem in such a way that the fitness of an evolving chromosome relative to the task at hand can be mapped to a single value. This can be minimisation of error, or some other objective value, such as cost, time taken or accuracy in performing a task. In situations where there is a single goal in mind, even if there are a number of parameters to be optimized, a single objective function can be applied. Care must be taken when combining the parameters to ensure that the resultant single fitness value is properly representative of the performance of the chromosome.  Reducing the idealised optimum state for a chromosome to a single value can have disadvantages.  If a given problem has many aspects that must be tested for error, and those various error values are then combined into a single value, most often an error value which must be minimised.  In this combination process, some information is lost, possibly reducing the ability of the EA to converge on a reasonable solution. When this method is used, normally only one member of a population can be declared the winner of the evolutionary process, through achieving the highest score, the exception being when the population is separated into competing groups, such as in the Island model. In SHC, this method is the predominant form of objective function, although alternative methods have been investigated [5].

</p>
<h4>Multi Objective Optimisation</h4>
<p>
Not all problems are best considered as single objective. In nature, organisms subjected to evolutionary pressures must of necessity do well at several tasks which are not always complementary. For example to succeed, an organism must become good at finding and consuming food, whist at the same time be good at avoiding predators. The one activity conflicts with the other, since more time spent concentrating on finding food means less time watching for predators. This need to satisfy multiple conflicting  objectives at the same time is an issue in data mining [8], where pattern searching is performed on typically large datasets. A good data mining method is not one which locates the target pattern 100% of the time, but instead one which is able to discriminate between patterns of interest and patterns which do not conform sufficiently to the target profile. As a result it become necessary not to evolve the perfect classifier, but instead to evolve the classifier which is best at both tasks, identifying the desired patterns, and identifying and then rejecting incorrect ones.
</p>
<p>
It was the work of Economist Vilfredo Pareto (1848 to 1923) which formed the basis for the concept of multiobjective optimisation. He introduced the concept that the solution to a problem with conflicting objectives is not normally a single value, but is instead formed from a combination of values, known as the Pareto set. A solution to such a problem is known as Pareto Optimal [6] if a balance between the objectives has been achieved such that there is no way in which one criteria can be reduced without increasing another. This approach usually results in a number of possible solutions emerging, rather than the more usual (in single objective optimisation) single solution. This set of pareto optimal solutions are known as the Pareto front [9], and its members are referred to as the non-dominated members of the population of potential solutions, with those members of the population not in the Pareto front being described as the dominated members (we will explain this in more detail shortly).
</p>
<p>
This is of particular interest in data mining [8], where the reduction of false positive detections is as important as maximizing the number of true positive detections. There are now many evolutionary algorithms that use multiobjective information to achieve a good balance between conflicting objectives. Some methods evaluate the individual criteria of a problem in such a way as to combine them into a single answer. Objective weighting [7] assigns a weight to each objective which will form the final single answer, where all weights sum to 1. One of the objectives within a set can be given priority (the highest weight), or all objectives can be assigned equal weight, indicating a trade off is required. This method produces a single solution and does not assure that the result will be Pareto optimal, and requires a priori information regarding the relative importance of each objective.
</p>
<p>
Minmax optimisation [10] on the other hand, which also produces a single answer rather than a Pareto front, does not require a priori information. This technique seeks to minimise the conflict between the various objective functions, giving none priority over another, with the resultant fitness results being combined into a single value. Once again the result is a single final answer which is not assured to be Pareto Optimal.
</p>
<p>
In order to obtain a set of Pareto optimal solutions on the Pareto front, the various objectives which are to be optimised are not combined, but are instead kept as separate values in a vector [11].  Chromosomes in the population are then compared to discover which values in the vector dominate (contain a better score than) the equivalent scores held by other member of the population [12] . Members of the population which are non-dominated in all fitness measures in this vector are considered to form the Pareto front. The population is thus separated into two sets, those that are dominated, and those that are non-dominated.
</p>

<p>
A dominated chromosome is one which, if we use the two objective case, is at best equal in performance in one objective to at least one other chromosome in the population, and inferior on the other. At worse its performance on both objectives is inferior. Either situation will cause the chromosome to be placed in the dominated set.
</p>
<p>
Non-dominated chromosomes in the Pareto front must also be equally non dominating when compared against each other. That is, they must, for the two objective case, be superior in one measure with respect to each other member of the Pareto front, and inferior in another. Further, only those chromosomes which are in the Pareto front (the non-dominated set) are eligible to be selected for breeding. With this Elitist [13] approach, rather than a single winning chromosome once evolution is concluded, all members of the Pareto front are available. Since all members of the Pareto front must also be equally non dominating with respect to each other, the set of answers is assured to be varied, providing a selection of different answers to a problem from a single experiment. While the examples above refer only to the two objective case, this extends to however many objectives are required in a given situation.
</p>
<p>
The multiobjective EA is well suited to evolving discriminators. Now a chromosome can only survive if it find the best trade off between the conflicting objectives of identifying  patterns that conform to the target pattern in data whilst also identifying those which do not conform to the target pattern, even when they may well share some similarities. Thus a chromosome which can identify 100% of the target patterns but has a high rate of mis-classification of incorrect patterns will be supplanted by another which does not identify as many target patterns but is better at rejecting false positives. Superior solutions will thus tend to be placed at the mid point of best performance between each objective. This is referred to as finding a good position in the trade off space of the problem, and is demonstrated graphically in figure 1-1.
</p>
 Figure 1 1: Chart of a hypothetical Multi-Objective problem revealing the performance trade off region which corresponds to the Pareto trade off space for that problem
<p>
<img src="/images/pareto.png" alt="pareto trade off space" />
</p>
<div class = "horizontalDivider"></div>
<p>

[1] S. Kirkpatrick, C. D. Gelatt, Jr., M.P. Vecchi, ‘Optimization by Simulated Annealing’, Science, Number 4598, 13 May 1983
</p>
<p>
[2] Metropolis, N., Rosenbluth, A.W., Rosenbluth, M. N., Teller, A.H. and Teller, E., ‘Equations of State Calculations by Fast Computing Machines’, J. Chem. Phys. 21, 1087- 1092, 1958
</p>
<p>
[3] Ian H. Witten and Eibe Frank, ‘Data Mining’, Morgan Kaufman publishers, 2000
</p>
<p>
[4] Kenneth A. De Jong, William M. Spears, ‘A Formal Analysis of the Role of Multi-Point Crossover in Genetic Algorithms’, Annals of Mathematics and Artificial Intelligence, 5, 1, 1-26, 1992
</p>
<p>
[5] Smith, K.I.   Everson, R.M.   Fieldsend, J.E., ‘Dominance measures for multi-objective simulated annealing’, Proceedings of the 2004 Congress on Evolutionary Computation. Vol.1, 19-23 June 2004
</p>
<p>
[6] Vilfredo Pareto, 'Cours D'Economie Politique', Volume I and II. Rouge, Lausanne, 1896
</p>

<p>
[7] Messac, A., “Physical Programming: Effective Optimization for Computational Design,” AIAA J., 34, 149,1996
</p>
<p>
[8]  Ian H. Whitten, Eibe Frank, ‘ Data Mining – Practical machine learning tools and techniques with Java Implementations’, Morgan Kauffmann Publishers, 2000
</p>
<p>
[9] D. Dumitrescu, Crina Grosan and Mihai Oltean, ‘A New Evolutionary Approach for Multiobjective Optimization’, Studia Universitatis Babes--Bolya, XLV, 1, 51--68, 2000
</p>
<p>
[10] C. H. Tseng, T. W. Lu, 'Minimax multiobjective optimization in structural design', International Journal for Numerical Methods in Engineering, Volume 30, 6, pages 1213-1228,1990
</p>
<p>
[11] J. D. Schaffer. 'Some experiments in machine learning using vector evaluated genetic algorithms', Vanderbilt University, Nashville, TN.1984.
</p>
<p>
[12] Goldberg. D.E. ‘Genetic algorithms in search, optimization and machine learning’, Addison-Wesley, 1989

</p>
<p>
[13] Zitzler, E. and L. Thiele, ‘Multiobjective evolutionary algorithms: A comparative case study and the strength pareto approach’. IEEE Transactions on Evolutionary Computation.  3,4, p 257 - 271. 1999
</p>

<p>All these papers are available for download on my <a href="http://www.politespider.com/papers.php" target="_blank"  style = "color: #F26522;font-weight: bold; text-decoration: underline;">thesis bibliography page</a> </p>
<a href="#top" style = "font-weight: bold; text-decoration: underline;">Back To Top</a>
</div>
<?php
include("includes/footer.php");
?>
