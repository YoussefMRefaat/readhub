# ReadHub

Book review and rating Backend API built using ***Laravel***

## Features

This application has three types of roles:- 
- Admin
- User
- Guest
<br><br>
#### All roles can:-
1- Read books <br>
2- Read reviews <br>
3- Read likes and dislikes of a review <br>
4- Read the updating history of the comment of a review
<br> <br>
#### Guests can:-
1- Sign-up or sign-in with email and password <br>
2- Sign-up or sign-in with Google account <br>
<br>
#### Authenticated accounts can:-
1- Update information and password <br>
2- Logout <br>
3- Delete the account <br>
<br>

#### Admins can:-
1- Create, read, update, and delete authors <br>
2- Create, read, update, and delete books <br>
3- Delete users <br>
4- Delete reviews <br>
<br>
#### Users can:-
1- Review a book <br>
2- Update and delete their review <br>
3- Like or dislike a review <br>
<br>

## Entity relationship diagram
![ERD](ERD.png)

## Packages

[Laravel Sanctum](https://laravel.com/docs/8.x/sanctum) <br>
[Laravel Socialite](https://laravel.com/docs/8.x/socialite) <br>


## License

[MIT license](https://opensource.org/licenses/MIT).
