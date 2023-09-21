//Медиа запрос для работы выдвижного бокового меню
const mediaQuery = window.matchMedia('(min-width: 768px) and (max-width: 1239px)');
if (mediaQuery.matches) {
    console.log('Media Query Matched!');
    let menu_icon = document.querySelector(".menu_icon");
    let sidenav = document.querySelector(".sidenav");
    let exit_icon = document.querySelector(".exit_icon");
    let lis = document.querySelectorAll(".li");

    menu_icon.onclick = function(){
        sidenav.classList.add("active");
        document.body.classList.add('disable-scroll');
    }

    exit_icon.onclick = function(){
        sidenav.classList.remove("active");
        document.body.classList.remove('disable-scroll');
    }

    lis.forEach((li) => {
        li.onclick = function(){
            let parent = li.parentElement;
            let sub_ul = parent.querySelector(".sub_ul");
            sub_ul.classList.toggle("closed");
        }
    });
}

//Открытие и закрытие панели фильтров
if (document.querySelector(".hidden_filter_block") != null){
    let filter = document.querySelector(".hidden_filter_block");
    let filter_button = document.querySelector(".filter_icon");

    filter_button.onclick = function(){
        filter.classList.toggle("closed");
    }
}

//Ассинхронный запрос подкатегорий
if (document.getElementById('category_id') != null){
    var category_select = document.getElementById('category_id');
    var subcategory_select = document.getElementById('subcategory_id');
    category_select.addEventListener('change', function(){  
        var index = this.value;
        console.log(index)
        subcategory_select.innerHTML='';
        $.get('query.php', {category_id: index}, function(data){
            var subcategories = JSON.parse(data);
            if (subcategories == 0){
                let newOption = new Option("Нет", 0);
                subcategory_select.append(newOption);
            }
            else {
                for (let id in subcategories){
                    let newOption = new Option(subcategories[id], id);
                    subcategory_select.append(newOption);
                }
            }
        });
    });
}

//Ассинхронный запрос подстендов
if (document.getElementById('stand_id') != null){
    var stand_select = document.getElementById('stand_id');
    var substand_select = document.getElementById('substand_id');
    stand_select.addEventListener('change', function(){  
        var index = this.value;
        console.log(index)
        substand_select.innerHTML='';
        $.get('query.php', {stand_id: index}, function(data){
            var substands = JSON.parse(data);
            if (substands == 0){
                let newOption = new Option("Нет", 0);
                substand_select.append(newOption);
            }
            else {
                for (let id in substands){
                    let newOption = new Option(substands[id], id);
                    substand_select.append(newOption);
                }
            }
        });
    });
}

//Автозаполнение полей
if (document.getElementById('ovks_input') != null){
    var ovks_input = document.getElementById('ovks_input');
    var unks_input = document.getElementById('unks_input');
    var bts_input = document.getElementById('bts_input');
    ovks_input.addEventListener('change', function(){  
        var num = parseFloat(this.value);
        bts_input.value = num + parseFloat(unks_input.value);
    });
    unks_input.addEventListener('change', function(){  
        var num = parseFloat(this.value);
        bts_input.value = num + parseFloat(ovks_input.value);
    });
    bts_input.value = parseFloat(ovks_input.value) + parseFloat(unks_input.value);
}

//Ассинхронный запрос подсущностей
if (document.getElementById('entity_id') != null){
    var entity_select = document.getElementById('entity_id');
    var subentity_select = document.getElementById('subentity_id');
    entity_select.addEventListener('change', function(){  
        var index = this.value;
        console.log(index)
        subentity_select.innerHTML='';
        $.get('query.php', {entity_id: index}, function(data){
            var subentities = JSON.parse(data);
            if (subentities == 0){
                let newOption = new Option("Нет", 0);
                subentity_select.append(newOption);
            }
            else {
                for (let id in subentities){
                    let newOption = new Option(subentities[id], id);
                    subentity_select.append(newOption);
                }
            }
        });
    });
}

//Ассинхронный запрос сущностей
if (document.getElementById('stand_id') != null){
    var stand_select = document.getElementById('stand_id');
    var entity_select = document.getElementById('entity_id');
    stand_select.addEventListener('change', function(){  
        var index = this.value;
        console.log(index)
        entity_select.innerHTML='';
        $.get('query.php', {stand_id: index}, function(data){
            var entities = JSON.parse(data);
            console.log(entities)
            if (entities == 0){
                let newOption = new Option("Нет", 0);
                entity_select.append(newOption);
            }
            else {
                for (let id in entities){
                    let newOption = new Option(entities[id], id);
                    entity_select.append(newOption);
                }
            }
        });
    });
}

//Ассинхронный запрос полуфабрикатов
if (document.getElementById('entity_id') != null){
    var entity_select = document.getElementById('entity_id');
    var sf_product_select = document.getElementById('sf_product_id');
    entity_select.addEventListener('change', function(){  
        var index = this.value;
        console.log(index)
        sf_product_select.innerHTML='';
        $.get('query.php', {entity_id: index}, function(data){
            var sf_products = JSON.parse(data);
            console.log(sf_products)
            if (sf_products == 0){
                let newOption = new Option("Нет", 0);
                sf_product_select.append(newOption);
            }
            else {
                for (let id in sf_products){
                    let newOption = new Option(sf_products[id], id);
                    sf_product_select.append(newOption);
                }
            }
        });
    });
}

