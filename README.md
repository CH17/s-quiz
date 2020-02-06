# S-Quiz

S-Quiz is a simple WP plugin to generate quiz and get users feedback

### Info


- Contributors: CH17
- Tags: quiz, wp-quiz
- Requires at least: 3.5.1
- Tested up to: 5.3.1
- Stable tag: 2.1.0



### Installation

```php
- Upload 's-quiz' to the '/wp-content/plugins/' directory
- Activate the plugin through the 'Plugins' menu in WordPress
```


### Usage


- Go to ***Quizzes > Add New*** – to create new quiz. Add title and options. Then select **Correct Answer** if this one is the correct answer. 
- Create more answer using ***Add Another Entry*** Button. 
- Select one or more **Subject** if you have multiple sets. 
- Finally Publish your quiz set.
- To display any set of quiz into pages or posts: use shortcode
``` [s_quiz subject="quiz_subject" layout="1 or 2" result_type="mark/percentage" show="correct_result"][/s_quiz]```
* Parameters:
   * ```subject:  title of you subject or set ```
   * ```layout:  1 : one after another ```  or ``` 2 : all in one page ```
   * ```result_type: mark: display result as marks 10/10 ``` or ```percentage: display result as percentage eg. 85%```
  * ```show:  if you want to display correct answer to the user after the test ```
 
- Admin can see participation list from ***Quizzes > Participates*** menu.

### Demo
[S-Quiz Demo](http://lab.systway.com/s-quiz/2016/06/17/demo-quiz/)


### Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

### Acknowledgement
[CMB2](https://github.com/CMB2/CMB2)


### License

- License: GPLv2 or later
- License URI: <http://www.gnu.org/licenses/gpl-2.0.html>
