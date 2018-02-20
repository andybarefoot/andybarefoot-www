var bodyHTML;

function dom400(){
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
      newSpan.appendChild(listItems[y].getElementsByTagName("H3")[0]);
      thisCollection.insertBefore(newSpan, listItems[y]);
    }

    // colLength = thisCollection.length;
    // var listItems = thisCollection.getElementsByTagName("H1")[0]
    // var newspan1 = document.createElement("span");
    // thisCollection[y].parentNode.insertBefore(newspan1, thisCollection[y].nextSibling);
    var newspan0 = document.createElement("span");
    thisCollection.appendChild(newspan0);
    var newspan0 = document.createElement("span");
    thisCollection.appendChild(newspan0);
  }

}


function domReset(){
  document.getElementsByTagName("BODY")[0].innerHTML = bodyHTML;
}

function loaded(){
  bodyHTML = document.getElementsByTagName("BODY")[0].innerHTML;
  dom400();
}

document.onload = loaded();
