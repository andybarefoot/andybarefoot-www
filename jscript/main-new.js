var bodyHTML;

function domMobile(){
  console.log("domMobile");
  var ribbons = document.getElementsByTagName("H1")[0];
  var ribbonArr = ribbons.innerHTML.split("<br>");
  ribbons.innerHTML="";
  ribbons.appendChild(document.createElement("span"));
  for(x=0;x<ribbonArr.length;x++){
    var newspan1 = document.createElement("span");
    var newtext1 = document.createTextNode(ribbonArr[x]);
    var newspan2 = document.createElement("span");
    newspan1.appendChild(newtext1);
    ribbons.appendChild(newspan1);
    ribbons.appendChild(newspan2);
  }
  var social = document.createElement("span");
  social.appendChild(document.getElementById('social'));
  ribbons.appendChild(social);
  ribbons.appendChild(document.createElement("span"));
  var portrait = document.createElement("span");
  portrait.appendChild(document.getElementById('portrait'));
  ribbons.appendChild(portrait);

  var collections = document.getElementsByClassName('collection');
  for(x=0;x<collections.length;x++){
    var thisCollection = collections[x];
    thisCollection.insertBefore(document.createElement("span"), thisCollection.getElementsByTagName("H2")[0]);
    var listItems = thisCollection.getElementsByTagName("li");
    for(y=0;y<listItems.length;y++){
      var newSpan = document.createElement("span");
      newSpan.appendChild(listItems[y].getElementsByTagName("a")[0]);
      thisCollection.insertBefore(newSpan, listItems[y]);
    }

    var newspan0 = document.createElement("span");
    thisCollection.appendChild(newspan0);
    var newspan0 = document.createElement("span");
    thisCollection.appendChild(newspan0);
  }
}

function domTablet(){
  console.log("domTablet");
  var header = document.getElementsByTagName("h1")[0];
  var headerArr = header.innerHTML.split("<br>");
  var social = document.getElementById('social');

  for(x=0;x<headerArr.length;x++){
    var header = document.createElement("h1");
    var newHeaderText = document.createTextNode(headerArr[x]);
    header.appendChild(newHeaderText);
    var newList = document.createElement("li");
    newList.classList.add("headline");
    newList.appendChild(header);
    social.appendChild(newList);
  }
  document.getElementsByTagName("h1")[0].remove();
  for(x=0;x<17;x++){
    var newHole = document.createElement("li");
    newHole.classList.add("hole");
    social.appendChild(newHole);
  }
  for(x=0;x<25;x++){
    var newBlank = document.createElement("li");
    newBlank.classList.add("blankCell");
    social.appendChild(newBlank);
  }
  var allLists = document.getElementsByTagName("ul");
  var listCount = allLists.length;
  var newList = document.createElement("ul");
  newList.id = "bricks";
  for(var x=1;x<allLists.length;x++){
    var listID = allLists[x].id;
    var listItems = allLists[x].children;
    for(var y=0;y<listItems.length;y++){
      if(listItems[y].tagName.toLowerCase()=="li"){
        var newDiv = document.createElement("div");
        newDiv.classList.add("content");
        newDiv.innerHTML = listItems[y].innerHTML;
        var newListItem = document.createElement("li");
        newListItem.appendChild(newDiv);
        newListItem.classList.add(listID);
        newListItem.classList.add("brick");
        newList.appendChild(newListItem);
      }
    }
  }
  document.body.appendChild(newList);
  for(var x=listCount-1;x>0;x--){
    allLists[x].remove();
  }

  allItems = document.getElementsByClassName("brick");

  for(x=0;x<allItems.length;x++){
    imagesLoaded( allItems[x], resizeInstance);
  }

  resizeAllGridItems();
}

function resizeGridItem(item){
  grid = document.getElementById("bricks");
  rowHeight = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-auto-rows'));
  rowGap = parseInt(window.getComputedStyle(grid).getPropertyValue('grid-row-gap'));
  rowSpan = Math.ceil((item.querySelector('.content').getBoundingClientRect().height-20+rowGap)/(rowHeight+rowGap));
  item.style.gridRowEnd = "span "+rowSpan;
  console.log("-------");
  console.log(rowHeight);
  console.log(rowGap);
  console.log(rowSpan);
  console.log(item.querySelector('.content').getBoundingClientRect().height);
  console.log("-------");
}

function resizeAllGridItems(){
  allItems = document.getElementsByClassName("brick");
  for(x=0;x<allItems.length;x++){
    resizeGridItem(allItems[x]);
  }
}

function resizeInstance(instance){
  item = instance.elements[0];
  resizeGridItem(item);
}


function loaded(){
  console.log("loaded");
  bodyHTML = document.getElementsByTagName("BODY")[0].innerHTML;
  getSize();
}

function getSize(){
  console.log("get size");
  if(window.innerWidth<=600){
    domMobile();
  }else{
    domTablet();
  }
}

document.onload = loaded();
window.onresize = function() {
  console.log("resized");
  document.getElementsByTagName("BODY")[0].innerHTML = bodyHTML;
  getSize();
};


