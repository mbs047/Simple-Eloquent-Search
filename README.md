# Simple Eloquent Search
A laravel package to search via your models .

installation : 
`composer require devhereco/SimpleEloquentSearch`

Usage :
- use `Searchable` trait in your model
- Define `$searchable` property in your model to select which columns to search in

Example :

```php
use devhereco\SimpleEloquentSearch\Searchable;

class User extends Model {

  use Searchable ;
  protected $searchable = ['name', 'posts.title'];
  
  public function posts(){
    return $this->hasMany(Post::class);
  }