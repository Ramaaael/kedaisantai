CREATE DATABASE kedaikopi{
    CREATE TABLE loginkasir{
        username VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        INSERT username admin,
        INSERT password 123,
    }
    CREATE TABLE loginkasir{
        menu_id INT AUTO_INCEREMNT PRIMARY KEY,
        name VARCHAR(255) NOT NULL,
        price DECIMAL(10,2) NOT NULL,
        image_url VARCHAR(255) NOT NULL

        INSERT ALL MENU
    }

    CREATE TABLE orders {
        id INT AUTO_INCEREMNT PRIMARY KEY,
        menu_id INT NOT NULL,
        quantity INT NOT NULL,
        order_date TIMESTAMP CURRENT_TIMESTAMP,
        customers_id INT NOT NULL
        FOREIGN KEY (menu_id) REFERENCES menu_items(menu_id)
        FOREIGN KEY (customers_id) REFERENCES regist(id)
    }
    CREATE TABLE regist {
        id INT AUTO_INCEREMNT PRIMARY KEY,
        INSERT id (1)
    }
}
pancakes 20k
rotbak 13k
stroop wafel 18k
pretzels 20k
bagel sandwhich 25k
donat 15k
croissant 17l