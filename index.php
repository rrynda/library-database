<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>PHP Playground</title>
    </head>
    <body>
        <?php
            echo "Hello, World!<br>\n"; //display Hello World
                                    //echo acts as a print statement
                                    //<br> is HTML that = \n, used for formatting for user viewing
                                    // \n is php for displaying formatting for the computer or when viewing the code behind a web page [CTRL + u]

            //php can be commented in just like in java
            /*even the multi-line  commenting is the same as in java
             *  What bliss to have similar conventions across languages.
             *  Well, maybe not bliss because then one must remember what
             *  is the same and what is different between languages.
             */
            #this is also a way to comment in php
            
            //all keywords are not case sensitive
            EcHo "You say goodbye and I say hello,<br>hello, hello. I don't know why you say goodbye, I say hello.<br>\n";// display a lyric
            
            $color = "red"; //create variable color and set it to red
            $Color = "white"; //create variable Color and set it to white
            $ColoR = "blue";// create vaiiable ColoR and set it to blue
            echo "Every heart beats true for the " . $color . ", $Color, and " . $ColoR . ".<br>\n"; //display a lyric from a different song
            //all variable names are case senesitive
            //variables...
            
            // $[variabaleName] = [variable]
                //if variable = text, the it must be initialized with ""
                //if variable is a number, the no "" are needed
            
            //text variables can be displayed (as in line 33) with either:
                //. $[variable] . between closing and open "s
                // left as is right in text: "The $dog fetched."
            
            $x = 2;
            $y = 3;
            echo $x + $y . "<br>"; //calculate and display x + y 
            //ERROR in the line below this one
            echo "<br>When x = 2 and y = 3, then x + y = " . $x + $y . "<br>"; //display verbage and x + y
            $z = $x + $y;
            echo "When x = 2 and y = 3, then x + y = $z<br>\n"; //display verbage and variable z
            
            //variables declared outside a function have global scope and cannot be accessed within a function
            //local variables must be declared within the function
            $w = 1;
            function globalTest()
            {
                echo "Variable w inside the function looks like this: $w<br>";
            }
            globalTest();
            echo "Variable w outside the function looks like this: $w<br>\n";
            //functions act like methods in java
            
            //the global keyword is used by a function to access a global variable
            $v = 4;
            $u = 6 ;
            function globalTest2()
            {
                global $v, $u;
                $u = $v + $u;
            }
            globalTest2();
            echo "The total of v and u is $u<br>\n"; //display u after v has been added to it
            
            //global variables can also be called in functions with $GLOBALS['variable name']
            $t = 7;
            $s = 8;
            function globalTest3()
            {
                $GLOBALS['t'] = $GLOBALS['t'] + $GLOBALS['s'];
            }
            globalTest2();
            echo "The total of t and s is $t<br>\n"; //display t after s has been added to it
            
            //the static keyword is used to prevent variables from being trashed after it has been used
            function myTest()
            {
                static $r = 0; //r is made static so it won't be trashed after first use
                echo $r/*, $q*/; //display r and q
                $r++;
            }
            function myTest2()
            {
                $q = 9; //q is not made static so it will betrashed after first use
                $q++;
            }
            myTest();
            echo "<br>";
            myTest();
            echo "<br>";
            myTest();
            echo "<br>\n";
            myTest2();
            echo "<br>";
            myTest2();
            echo "<br>";
            myTest2();
            echo "<br>";
            
            //testing the claim that variables will be deleted once they have been executed
            function deleteTest()
            {
                $p = 10;
                echo "p = " . $p . "<br>";
                echo "p = " . $p . "<br>";
            }
            deleteTest();
            echo "If variables cannot be used outside a function because their data has already been deleted, then<br>";
            echo $p . " p = <br>\n/";
            /* **variables initialized inside functions do not work outside of functions as once the function has finished executing, all of its data is deleted**
             *  the static keyword saves function variables from being deleted
             */
            
        //echo and print
            /*echo
                * no return value
                * can take multiple paramters
                * marginally faster than print
                * can be used with or without ()
             */
            /*print
                * return value of 1, can therefore be used in expressions
                * takes one argument
                * marginally slower than echo
             */
            
            //echo text can contain HTML code too; EX <br>, <h2>
            echo "<h3>This was displayed using an echo statement</h3>";
            echo "Hello again, World!<br>";
            echo "I've been learning PHP.<br>";
            echo "This ", "string ", "was ", "made ", "with multiple parameters.";
            
            //EXs on outputting text with variables (in case you have yet to get the gist of it from the above code)
            $txt1 = "Learning echo in PHP";
            $txt2 = "http://www.w3schools.com/php/default.asp";
            $o = 11;
            $n = 12;
            echo "<h3>$txt1</h3>";
            echo "Study PHP at $txt2<br>";
            echo $x + $y . "<br>\n";
            
            //print text can also contain HTML code
            print "<h3>This was displayed using a print statement.</h3>";
            print "<br>";
            print "Learning PHP is very similar to Java is nice.<br>\n"; //display some sample linesof print statements
            
            //displaying variables using print
            $txt3 = "Learning print in PHP";
            $txt4 = "http://www.w3schools.com/php/default.asp";
            $m = 13;
            $l = 14;
            print "<h3>$txt3</h3>";
            print "Continue studey of PHP at $txt4<br>";
            print $m + $l . "<br>\n";
            
        //data types
            /*these data types are supported:
                * string
                * integer
                * float[double]
                * boolean
                * array
                * NULL
                * resource- stores a reference to functions/resources outside of php
             */
            //var_dump() is a function that returns the data type and value.  It works on multiple data types
            //EX of string
            $txt5 = "Howdy!";
            var_dump($txt5);
            print "<br>";
            //EX of integer
            $k = 1516;
            var_dump($k);
            print "<br>";
            //EX of float
            $j = 6.11;
            var_dump($j);
            print "<br>";
            //EX boolean.  Used with condidtions
            $TF = true;
            $TF2 = false;
            var_dump($TF);
            var_dump($TF2);
            print "<br>";
            //EX array
            $games = array("Uncharted", "Mass Effect", "XCOM");
            var_dump($games);
            print "<br>";
            //EX object
            //create a class
            class Car
            {
                function car()
                {
                    $this->model = "Ford"; //this == java's this.[name]
                }
            }
            //create object
            $KIT = new Car();
            //show object properties
            echo $KIT->model;
            print "<br>";
            //EX Null.  Variable is null by default until it is given a value. values can be turned null (duh)
            $i = null;
            var_dump($i);
            $i = 17;
            $i = null;
            var_dump($i);
            print "<br>\n";
            //EX resource
            //EX: database call
            
        //Strings
        echo "<h3>Working with Strings</h3>";
            //get length of string
            echo strlen("Hello, World!"); //outputs length
            echo "<br>\n";
            
            //reverse a string
            echo strrev("Hello, World!"); //outputs reversed string
            echo "<br>\n";
            
            //find characters within a string,
            echo strpos("Hello, World!", "orld"); //displays the the position of first match
            echo "<br>\n";
            echo strpos("Hello, World!", "w"); //returns FALSE if no matches are found
            echo "<br>\n";
            //0 != FALSE, it means position 0, think base 0
            
            //find/replace first instance in a string
            echo str_replace("World", "sir", "Hello, World!");  //replaces World with sir and display string with changes
            echo "<br>\n";
            
        //constants
            //to create a constant:
                //define([name], [value], [case-(in)sensitive])
                //case-sensitivity: default false
                    //false = case-sensitive
                    //true = case-insensitive
            
            define("hi", "Welcome to Jurassic Park.");
            echo hi;
            echo "<br>";
            define ("GREETING", "Welcome to Jurassic World.", true);
            echo greeting;
            echo "<br>\n";
            
            //constants are automacially global
            function myTest3()
            {
                echo hi;
                echo "<br>\n";
            }
            myTest3();
            
        //Operators
            /*types of operators:
                * arithmetic
                * assignment
                * comparison
                * increment/decrement
                * logical
                * string
                * array
             */
            //arithmetic: +, -, *, /, %, **
                //x % y = remainder of x divided by y
                //x ** y = taking x to the yth power
            //refreasher: x (operator) y  is the same as x = x (operator) y
            
            /*comparison operators:
                * == is equal; x == y, return true is x = y
                * === is identical; x === y, return true is x = y and they are the same type
                * != is <> is not equal; x != y, x <>y, return true is x != y
                * !== is not identical; x !== y, return true if x != y or are different types
                * > ; return true of x > y
                * < ; return true is x < y
                * >= ; return true if x >= y
                * <= ; return true is x <=y
             */
            
            /*increment/decrement
                //just like in java but remember that php variables have $ in front
                * ++$x
                * $x++
                * --$x
                * $x--
             */
            
            /*logical operators
                //very similar to java logical operators
                * and ; &&
                * or ; ||
                * xor
                * ! (not)
             */
            
            /* string operators
                * . concatenation- joining strings together
                * .= concatenation assignment- append latter to former
             */
            // .=
            $txt6 = "This sentence ";
            $txt7 = "is false.";
            $txt6 .= $txt7;
            echo $txt6;
            echo "<br>\n";
            //echo $txt7; //a test whether the appended string is deleted after appendage, it is not
            
            /*array operators- compare arrays
                * + union
                * == equality- true if x and y have same key/value pairs
                * === identity- true if x and y have same key/value pairs in the same order ans with the same data types
                * != , <> inequality
                * !== non-identity- true if x is not identical to y
             */
            
            /*conditional statements
                * if
                * if...else
                * if...elseif...else
                * switch
             */
            
            //if
            $h = date("H"); //not sure what date does to the character H ( I think it may be looking at it as a date of a month now?) but if statement does not trip if the date() is left out of the initialization
            //$h = "H"; //assigns date to variable H
            if($h < "20")
            {
                echo "H < 20";
            }
            echo "<br>\n";
            
            //if...else
            $h = date("H");
            if($h < "5")
            {
                echo "H < 5";
            }else
            {
                echo "H >= 5";
            }
            echo "<br>\n";
            
            //if...elseif...else
            $h = date("H");
            if($h < "10")
            {
                echo "Have a good morning.";
            }elseif($h < "20")
            {
                echo "Have a good day.";
            } else
            {
              echo "Have a good night!";
            }
            echo "<br>\n";
            
            //switch
            //$g = "Ezio"; // tests default
            //$g = "Shepard"; //tests case Shepard
            //$g = "McTavish"; // tests case Soap
            $g = "Drake"; //tests case Drake
            switch($g)
            {
                case "Shepard":
                    echo "Shepard is the main character.";
                    break;
                case "McTavish":
                    echo "McTavish is the main character.";
                    break;
                case "Drake":
                    echo "Nathan Drake is the main character.";
                    break;
                default:
                    echo "Ezio must be the main character.";
            }
            echo "<br>\n";
            
        //loops
            //while
            //do...while
            //ffor
            //foreach
            
            //while
            $f = 18;
            while($f < 20)
            {
                echo "f < 20";
                $f++;
                echo "<br>";
            }
            echo "\n";
            
        ?>
    </body>
</html>
