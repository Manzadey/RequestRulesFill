# RequestFillRules

Данный класс предназначен для красивого (ИМХО) и упрощенного заполнения правил валидации в реквестах.

Установка:
```bash
composer require manzadey/request-rules-fill
```

Как пользоваться:
```php
use Manzadey\RequestRulesFill\RequestRulesFill;

$rules = new RequestRulesFill;
```
Добавляем поля и правила валидации:
```php
$rules->fields('name', 'description')->rule('string', 'required');
```
Заменяем правило в поле:
```php
$rules->replaceRule('slug', 'unique:articles', Rule::unique('articles')->ignore($this->route('article')->id));
```
Добавляем к полю правило:
```php
$rules->addRuleToField('slug', 'string', 'min:2');
```
Выводим правила в виде массива:
```php
$rules->get();
```


Наглядный пример использования данного класса:
Создаем класс `ArticleStoreRequest`, в нем создадим метод `makeRules` и создадим новый объект `RequestRulesFill`:
```php
namespace App\Http\Requests\Admin\Article;

use Manzadey\RequestRulesFill\RequestRulesFill;
use Illuminate\Foundation\Http\FormRequest;

class ArticleStoreRequest extends FormRequest
{
    public function rules() : array
    {
        return $this->makeRules()->get();
    }

    public function makeRules() : RequestRulesFill
    {
        $rules = new RequestRulesFill();
        $rules->fields('show', 'top')->rule('nullable', 'boolean');
        $rules->fields('name')->rule('required', 'string', 'min:3');
        $rules->fields('slug')->rule('nullable', 'string', 'alpha_dash', 'min:3', 'unique:articles');
         $rules->fields('description', 'description_short')->rule('nullable', 'string');
         
        return $rules;
    }
}
```

Далее создаем класс `ArticleUpdateRequest`, который унаследует класс `ArticleStoreRequest` с его правилами:
```php
namespace App\Http\Requests\Admin\Article;

use Illuminate\Validation\Rule;

class ArticleUpdateRequest extends ArticleStoreRequest
{
    public function rules() : array
    {
        return $this->makeRules()->get();
    }

    public function makeRules() : RequestRulesFill
        {
            return parent::makeRules()->replaceRule('slug', 'unique:articles', Rule::unique('articles')->ignore($this->route('article')->id));
        }
}
```