# e_commerce
Ecommerce backend project using PHP - MYSQL - Bootstrap - JQUERY  

## Hello , this is my notes and sequence of working with project

### Stage 1 --- Create project structure.
   #### tasks :
     1- Creating directories and organizing admin folder .
     2- Including main required files like header (consists of styling files ) and footer (consists of javascript and JQUERY)
        and index file which is main file that include header and footer files and main program structure .
     3- Adding tools and libraries to project (Bootstrab , awesomefonts , JQUERY , main css and js files ).
     4- Creating init.php file (initialize) which include Routes , languages , database connect , header ,... .
     5- Creating language files with array method .
     
### Stage 2 --- Create DATABASE .
   #### tasks : 
     1- Create database and tables .
     2- Create connect.php file .
     
### Stage 3 --- Design admin login page .
   #### tasks : 
    1- Design login form .
    2- Creating code of login authorization for admins only using GroupID column in database and hashed
       password and rowcount().
    3- Design and customzie the navigation bar and prevent it from appearing on login page using isset function
       of variable .
