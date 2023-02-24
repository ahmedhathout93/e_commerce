# e_commerce

Ecommerce backend project using PHP - MYSQL - Bootstrap - JQUERY

## Hello , this is my notes and sequence of working with first php project

### Stage 1 --- Create project structure.

#### tasks :

     1- Creating directories and organizing admin folder .
     2- Including main required files like header (consists of styling files ) and
        footer (consists of javascript and JQUERY) and index file which is main file that
        include header and footer files and main program structure .
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

### Stage 3 --- Create main pages .

#### tasks :

    1- Create logout page .
    2- Create functions page which include first function that will echo title of pages .
    3- Creating member page using (split method with GET request).
    4- start working in Edit page and adding registeration of UserID in session ID
       to make edit page dynamic and access specified user.
    5- Coding edit page ( validating numeric userid from session and make a query from database
         to fetch all data related to this userid and insert it in form)
    6- Coding update page as follow :
       - adding update route in edit form action attribute
       - use post method to send data from edit page to update page
       - update these data in DB
       - coding update method of password using additional hidden input and empty function
         to check is there a new password or add new one .
       - adding form validation errors in array and print it using foreach loop and bootstap danger class.
       - prevent updating DB if form validation not ok by checking if errors array is empty .
    7- Design add member and insert page and linking it with database .
    8- Design manage members page and fetch users info from database into members page table .
    9- Coding delete member page and create redirect function.
    10- Creating checkItem function which check if username or any DB info exists to avoid dublicate .
    11- clean up and improve previous pages .

### Stage 4 --- Dashboard .

#### tasks :

    1-
