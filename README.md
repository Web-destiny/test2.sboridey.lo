Yii2 Test Task 
-----------

This is a test task

Installation
------------

1. Virtual Host
```script
<VirtualHost 127.0.0.1:80>
  DocumentRoot "/var/www/yii2-app-advanced"  
  ServerName "yii2-test.loc"
  ServerAlias "yii2-test.loc" "www.yii2-test.loc" 
</VirtualHost>
```

2. Hosts file (/etc/hosts)
```script
* Add this line into hosts file

127.0.0.1 yii2-test.loc www.yii2-test.loc
```

Admin Panel Documentation
----------

* using adminlte 2.4.0

https://github.com/dmstr/yii2-adminlte-asset

* Using Rbac for Roles & Permissions

https://www.yiiframework.com/wiki/848/installation-guide-yii-2-advanced-template-with-rbac-system

* Admin User Credentials `` admin / 12345678 ``

Available URLs
----------

* Well done! Start using your amazing web APP

1. http://yii2-test.loc/  - Frontend
2. http://yii2-test.loc/backend/web/  - Backend (Admin Panel)

* OR -----> http://yii2-test.loc/admin
