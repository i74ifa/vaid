# Docs
<br>


## Requirements

* apache2
* php ^7.2|^8.0
* composer


## Install

### via composer
```
composer global require i74ifa/vaid

vaid install
```
If you haven't added composer tools to cli before, follow this

open Terminal and open .bashrc
```
echo -e '\nexport PATH=$HOME/.config/composer/vendor/bin:$PATH' >> ~/.bashrc
```

or add this line on ```~/.bashrc```

```
export PATH=$HOME/.config/composer/vendor/bin:$PATH
```

### **Manual**

clone this repo

extract file 


``` 
ln -snf /path/to/vaid/vaid /usr/local/bin

```

<div style="color: red;">You need absolute path</div>

## use

### link virtual host 

```
sudo vaid link 
```

### unlink virtual host 
```
sudo vaid unlink 
```
