<?

declare(strict_types=1);

namespace App\Controllers;

use App\View;
use PDO;

class HomeController
{
    public function index(): View
    {
        $db = new PDO('mysql:host=db;dbname=my_db','root','root',[
            
        ]);
        
        $query = 'SELECT * FROM users inner join invoices on users.id = invoices.user_id';
        $stmnt = $db->query($query);
        echo '<pre>';
        // foreach($stmnt as $user){
        //     print_r($user);
        // }

        return View::make('index', ['foo' => 'bar']);
    }

    public function upload()
    {
        var_dump($_FILES);

        $filePath = STORAGE_PATH . '/' . $_FILES['file']['name'];

        move_uploaded_file($_FILES['file']['tmp_name'], $filePath);
    }
}
