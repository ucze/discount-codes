Installation: 
========

    composer install
    
    
Usage: 
========
* via browser
* via console 


    php bin/console app:generate-codes 
    
 Options: 
 ========   
 * -u, --numberOfCodes=NUMBEROFCODES [default: 100]
 * -l, --lengthOfCodes=LENGTHOFCODES [default: 5]
 * -f, --filename=FILENAME           [default: "/tmp/codes.txt"]
 
 Example: 
 ========
 
 
     php bin/console app:generate-codes --numberOfCodes=100000 --lengthOfCodes=8 --filename=var/codes.txt
     
     
 Todo: 
 ========
 * tests
 * create interface for filesystem   
 * move max number of codes validation to form 
 * validate write access / file owerwrite
 
 Feedback:
 ========
 
 Any feedback is appreciated! 