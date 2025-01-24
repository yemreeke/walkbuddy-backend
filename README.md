
# Mobil Repo
https://github.com/yemreeke/walkbuddy-mobile


php artisan migrate    
- Bu database/ migrations/ içindeki dosyaları çalıştırır.
- dosyalar çalışınca database tabloları oluşur.


php artisan db:seed
- Bu database/ seeds/ içindeki dosyaları çalıştırır.
- dosyalar çalışınca database tabloları doldurulur.

routes/api.php 
- bu dosyada api listesi vardır.

- jwt middleware token kontrolü yapar.
- token varsa çalışır.
- token demek kullanıcıya özel veriler apiler demek.

app/Http/Controllers
- bu dosyada api listesi vardır.
- api listesindeki apilerin çalışma mantığı burada yazılır.
- apinin ne iş yaptığı burada yazılır.

app/Http/models
- bu dosyada database tabloları ile ilişkili modeller vardır.
