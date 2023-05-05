-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
-- Host: 127.0.0.1
-- Generation Time: May 02, 2023 at 05:58 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4
-- FILL event table
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
		' < p > What is smallest unit of the information ? < / p > < ol > 
		< li > A bit < / li > 
		< li > A byte < / li >
		 < li > A block < / li >
		  < / ol > ',
		1
	),
	(
		'general',
		1,
		' < p > What is the complement of 0011 0101 1001 1100 number ? < p > < ol > 
		< li > A bit < / li >
		 < li > A byte < / li > 
		 < li > A block < / li > 
		 < / ol > ',
		1
	),
	(
		'general',
		1,
		' < p > What is the decimal equivalent of the binary number 0011 0101 ? < / p > < ol > 
		< li > 1100 1010 < / li > 
		< li > 1101 1010 < / li >
		 < li > 1100 1111 < / li > 
		< / ol > ',
		1
	),
	(
		'general',
		1,
		' < p > Which of the following is equal to a gigabyte ? < / p > < ol >
		 < li > 1024 bytes < / li > 
		 < li > 512 GB < / li >
		  < li > 1024 megabytes < / li >
		   < / ol > ',
		3
	),
	(
		'general',
		1,
		' < p > What kind of language can computer understand ? < / p > < ol> 
		< li > Normal language < / li > 
		< li > High - level language < / li > 
		< li > Assembly language < / li >
		 < / ol > ',
		3
	),
	(
		'general',
		1,
		' < p > What is a single dot on a computer screen called ? < / p > < ol > > 
		< li > Desktop < / li > 
		< li > Pixel < / li > 
		< li > Color dot < / li >
		 < / ol > ',
		2
	),
	(
		'algorithm',
		1,
		' < p >
		Set
			of instructions for solving a problem
			or accomplishing a task ? < / p > < ol > 
			< li > Data type < / li >
			 < li > Data structure < / li >
			  < li > Algorithm < / li >
			   < / ol > ',
		3
	),
	(
		'data_structure',
		1,
		' < p > 1.The data elements in the structure are also known as what ? < / p > 
		< p >
		a) members < br > 
		b) data < br > 
		c) objects & amp;data < br > 
		< / p > ',
		1
	),
	(
		'data_structure',
		1,
		' < p > used to store data in an organised
and efficient manner ? </p> <ol> 
<li> OS </li> 
<li> Data Structure </li>
 <li> Programming language </li> 
</ol> ',
		2
	),
	(
		' oop ',
		1,
		' < p > a programming paradigm based on the concept of "objects" < / p > < ol > 
		< li > Flowchart < / li > 
		< li > Pseudocode < / li > 
		< li >(OOP) Object Oriented Programming < / li > 
		< / ol > ',
		3
	),
	-- 7 medium problems
	(
		'general',
		2,
		'<p> The language processor which converts assembly language into machine language is </p> <ol>
	<li>Interpreter</li>
	<li>Compiler Trees</li>
	<li>Assembler</li>
	</ol>',
		3
	),
	(
		'general',
		2,
		'<p>GUI stands for</p><ol>
	<li> Graphical Universal Interface</li>
	<li>Graphical User Interface</li>
	<li> Graphical User Inter-relation</li>
	</ol> ',
		2
	),
	(
		'algorithm',
		2,
		'<p>Which of the following sorting algorithms provide the best time complexity in the worst-case scenario?</p> <ol>
	<li>Merge Sort</li>
	<li>Bubble Sort</li>
	<li>Selection Sort</li>
	</ol> ',
		1
	),
	(
		'algorithm',
		2,
		'<p>Two main measures of the efficiency of an algorithm are?</p><ol>
	<li>Data & Space</li>
	<li>Processor & Memory</li>
	<li>Time  & Space complexity</li>
	</ol> ',
		3
	),
	(
		'data_structure',
		2,
		'<p>Which of the following is a linear data structure?</p> <ol>
	<li>Array</li>
	<li>Binary Trees</li>
	<li>Graphs</li>
	</ol> ',
		1
	),
	(
		'data_structure',
		2,
		'<p>What is the output of the following  snippet?</p><br>
	<code>
	void solve() {
   stack &lt;int&gt; s;
   s.push(1);
   s.push(2);
   s.push(3);
   for(int i = 1; i &lt;= 3; i++) {
       cout &lt;&lt; s.top() &lt;&lt; “ “;
       s.pop();
   }
}
</code>
<br>
<ol>
<li>1 2 3</li> 
<li>3 2 1</li> 
<li>3</li> 
</ol>',
		2
	),
	(
		' oop ',
		2,
		'<p>Under which pillar of OOPS do base class and derived class relationships come?</p> <ol>
	 <li> Inheritance </li>
	 <li> Polymorphism </li>
	 <li> Encapsulation </li>
	 </ol>',
		1
	),
	-- 4 hard problems
	(
		'algorithm',
		3,
		' < P > What is the time,
and space complexity of the following code:<br>
<code>
int a = 0, b = 0;
for (i = 0; i &lt; N; i++) {
    a = a + rand();
}
for (j = 0; j &lt; M; j++) {
    b = b + rand();
}
</code>< / p > < ol > 
< li > O(N * M) time, O(1) space < / li > 
< li > O(N + M) time,O(N + M) space < / li >
 < li > O(N + M) time,O(1) space < / li >
 < / ol > ',
		3
	),
	(
		'algorithm',
		3,
		' < p > Which of the following is not a backtracking algorithm? < / p > 
		< ol > < li > Knight tour problem < / li > 
		< li > N queen problem < / li > 
		< li > Tower of Hnoi < / li > < / ol > ',
		1
	),
	(
		'data_structure',
		3,
		' < p > What is the time complexity to
insert
	an element to the rear of a LinkedList(head pointer given) ? < / P > < ol > 
	< li > O(1) < / li >
	 < li > O(N) < / li > 
	 < li > O(log(N)) < / li >
	  < / ol > ',
		2
	),
	(
		'data_structure',
		3,
		' < p > Which of the following data structures can be used to implement queues ? < / P > < ol > 
			< li > Stack < / li > 
			< li > Arrays < / li > 
			< li > Linked List < / li >
			 < li > All the above < / li > 
			 < / ol > ',
		4
	);

COMMIT;