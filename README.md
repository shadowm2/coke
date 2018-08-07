# Beautiful API with Coke !

## Installation (Lumen)

```
$ composer require shadowm2/coke
```

Add this line in your bootstrap/app.php

```
$app->register(Shadow\Coke\CokeServiceProvider::class);
```

Use this alias for more comfort. add this line to your bootstrap/app.php  


```
class_alias(\Shadow\Coke\Facades\Coke::class, 'Coke');
```


## Usage
Define a function called "transform" in a model.
```
class User .... {
	...
	function transform() 
	{
		return [
			'name'	=> $this->name,
			'token'	=> "dummy"
		];
	}
}
```
Then your can use Coke like this:
```
use Coke;


$user = User::first();
$response = Coke::transform($user);
return $response;

// Output : {"name": "sth", "token": "dummy"}
```

Input to coke must be in this form:
```
Coke::tranform($data): $data must be Collection|Model|LengthAwarePaginator
```
If you want to use another transform function on a model and have multiple transform functions for a model, pass another parameter as below:

```
$changes = [
	'App\User' => 'anotherFunction' // keys in this array are path to your models
];

Coke::transform($user, $changes);
```



Adding relationships is just a breeze. You should add your relationships in your queries and define transform functions in each used model.
```
$data = User::first()->posts()->where('post_type', 2);
$response = Coke::transform($data);

/*
* Output: {'name': 'sth', 'token': 'dummy', 'posts': [{
*		...	
*	}]}
*
*/
```
In this example, posts is a hasMany relationship so each post is transformed individually.

Pagination is also supported.
```
$users = User::paginate();
return Coke::Transform($users);
```
