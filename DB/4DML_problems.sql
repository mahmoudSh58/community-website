-- phpMyAdmin version 5.2.1
-- https://www.phpmyadmin.net/
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET
	SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
	time_zone = "+00:00";

-- ----------------------------------------------------
-- FILL problems table ( 20 mcq )
INSERT INTO
	`problems` (`type`, `difficulty`, `statement`, `ans`)
VALUES
	-- 10 easy problems
	(
		'general',
		1,
		' <p>What is smallest unit of the information ? </p> <ul> 
		<li> A bit </li> 
		<li> A byte </li>
		 <li> A block </li>
		  </ul>',
		'a'
	),
	(
		'general',
		1,
		' <p>What is the complement of 0011 0101 1001 1100 number ? </p> <ul> 
		<li> 1100 1010 0110 0100 </li>
		 <li> 1100 1010 1111 1111 </li> 
		 <li> 1100 1010 1100 1011 </li> 
		 </ul> ',
		'a'
	),
	(
		'general',
		1,
		' <p>What is the decimal equivalent of the binary number 0011 0101 ? </p> <ul> 
		<li> 100 </li> 
		<li> 110101 </li>
		 <li> 53 </li> 
		</ul> ',
		'c'
	),
	(
		'general',
		1,
		' <p>Which of the following is equal to a gigabyte ? </p> <ul>
		 <li> 1024 bytes </li> 
		 <li> 512 GB </li>
		  <li> 1024 megabytes </li>
		   </ul> ',
		'c'
	),
	(
		'general',
		1,
		' <p>What kind of language can computer understand ? </p> <ul> 
		<li> Normal language </li> 
		<li> High - level language </li> 
		<li> Assembly language </li>
		 </ul> ',
		'c'
	),
	(
		'general',
		1,
		' <p>What is a single dot on a computer screen called ? </p> <ul>  
		<li> Desktop </li> 
		<li> Pixel </li> 
		<li> Color dot </li>
		 </ul> ',
		'b'
	),
	(
		'algorithm',
		1,
		' <p>Set of instructions for solving a problem or accomplishing a task ? </p> <ul> 
			<li> Data type </li>
			 <li> Data structure </li>
			  <li> Algorithm </li>
			   </ul> ',
		'c'
	),
	(
		'data_structure',
		1,
		' <p>The data elements in the structure are also known as what ? </p> 
		<ul>
		<li>members</li> 
		<li>data</li>
		<li>objects and data</li>
		</ul> ',
		'a'
	),
	(
		'data_structure',
		1,
		' <p>Used to store data in an organised
and efficient manner ? </p> <ul> 
<li> OS </li> 
<li> Data Structure </li>
 <li> Programming language </li> 
</ul> ',
		'b'
	),
	(
		' oop ',
		1,
		' <p>A programming paradigm based on the concept of "objects" </p> <ul> 
		<li> Flowchart </li> 
		<li> Pseudocode </li> 
		<li>(OOP) Object Oriented Programming </li> 
		</ul> ',
		'c'
	),
	-- 7 medium problems
	(
		'general',
		2,
		'<p>The language processor which converts assembly language into machine language is </p> <ul>
	<li>Interpreter</li>
	<li>Compiler Trees</li>
	<li>Assembler</li>
	</ul>',
		'c'
	),
	(
		'general',
		2,
		'<p>GUI stands for</p><ul>
	<li> Graphical Universal Interface</li>
	<li>Graphical User Interface</li>
	<li> Graphical User Inter-relation</li>
	</ul> ',
		'c'
	),
	(
		'algorithm',
		2,
		'<p>Which of the following sorting algorithms provide the best time complexity in the worst-case scenario?</p> <ul>
	<li>Merge Sort</li>
	<li>Bubble Sort</li>
	<li>Selection Sort</li>
	</ul> ',
		'a'
	),
	(
		'algorithm',
		2,
		'<p>Two main measures of the efficiency of an algorithm are?</p><ul>
	<li>Data & Space</li>
	<li>Processor & Memory</li>
	<li>Time  & Space complexity</li>
	</ul> ',
		'c'
	),
	(
		'data_structure',
		2,
		'<p>Which of the following is a linear data structure?</p> <ul>
	<li>Array</li>
	<li>Binary Trees</li>
	<li>Graphs</li>
	</ul> ',
		'a'
	),
	(
		'data_structure',
		2,
		'<p>What is the output of the following  snippet?<pre><code>
	void solve() {
		stack &lt;int&gt; s;
		s.push(1);
		s.push(2);
		s.push(3);
		for(int i = 1; i &lt;= 3; i++) {
			cout &lt;&lt; s.top() &lt;&lt; " ";
			s.pop();
   }
}</code></pre></p>
<ul>
<li>1 2 3</li> 
<li>3 2 1</li> 
<li>3</li> 
</ul>',
		'b'
	),
	(
		' oop ',
		2,
		'<p>Under which pillar of OOPS do base class and derived class relationships come?</p> <ul>
	 <li> Inheritance </li>
	 <li> Polymorphism </li>
	 <li> Encapsulation </li>
	 </ul>',
		'a'
	),
	-- 4 hard problems
	(
		'algorithm',
		3,
		' <p>What is the time,
and space complexity of the following code:
<pre><code>
int a = 0, b = 0;
for (i = 0; i &lt; N; i++) {
    a = a + rand();
}
for (j = 0; j &lt; M; j++) {
    b = b + rand();
}
</code></pre></p> <ul> 
<li> O(N * M) time, O(1) space </li> 
<li> O(N + M) time,O(N + M) space </li>
 <li> O(N + M) time,O(1) space </li>
 </ul> ',
		'c'
	),
	(
		'algorithm',
		3,
		' <p>Which of the following is not a backtracking algorithm? </p> 
		<ul> <li> Knight tour problem </li> 
		<li> N queen problem </li> 
		<li> Tower of Hnoi </li> </ul> ',
		'a'
	),
	(
		'data_structure',
		3,
		' <p>What is the time complexity to insert an element to the rear of a LinkedList(head pointer given) ? </p> <ul> 
	<li> O(1) </li>
	 <li> O(N) </li> 
	 <li> O(log(N)) </li>
	  </ul> ',
		'b'
	),
	(
		'data_structure',
		3,
		' <p>Which of the following data structures can be used to implement queues ? </p> <ul> 
			<li> Stack </li> 
			<li> Arrays </li> 
			 <li> All the above </li> 
			 </ul> ',
		'c'
	);

COMMIT;