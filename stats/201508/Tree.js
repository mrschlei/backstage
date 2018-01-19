//**************************************************************** 
// You are free to copy the "Folder-Tree" script as long as you  
// keep this copyright notice: 
// Script found in: http://www.geocities.com/Paris/LeftBank/2178/ 
// Author: Marcelino Alves Martins (martins@hks.com) December '97. 
//**************************************************************** 
window.saveNavigator = window.navigator;
// Handy functions
function noop() {}
function noerror() { return true; }
function defaultOnError(msg, url, line)
{
	// customize this for your site
	if (top.location.href.indexOf('_files/errors/') == -1)
		top.location = '/evangelism/xbProjects/_files/errors/index.html?msg=' + escape(msg) + '&url=' + escape(url) + '&line=' + escape(line);
}

// Display Error page... 
// XXX: more work to be done here
//
function reportError(message)
{
	// customize this for your site
	if (top.location.href.indexOf('_files/errors/') == -1)
		top.location = '/evangelism/xbProjects/_files/errors/index.html?msg=' + escape(message);
}

function pageRequires(cond, msg, redirectTo)
{
	if (!cond)
	{
		msg = 'This page requires ' + msg;
		top.location = redirectTo + '?msg=' + escape(msg);
	}
	// return cond so can use in <A> onclick handlers to exclude browsers
	// from pages they do not support.
	return cond;
}

function detectBrowser()
{
	var oldOnError = window.onerror;
	var element = null;
	
	window.onerror = defaultOnError;

	navigator.OS		= '';
	navigator.version	= 0;
	navigator.org		= '';
	navigator.family	= '';

	var platform;
	if (typeof(window.navigator.platform) != 'undefined')
	{
		platform = window.navigator.platform.toLowerCase();
		if (platform.indexOf('win') != -1)
			navigator.OS = 'win';
		else if (platform.indexOf('mac') != -1)
			navigator.OS = 'mac';
		else if (platform.indexOf('unix') != -1 || platform.indexOf('linux') != -1 || platform.indexOf('sun') != -1)
			navigator.OS = 'nix';
	}

	var i = 0;
	var ua = window.navigator.userAgent.toLowerCase();
	
	if (ua.indexOf('opera') != -1)
	{
		i = ua.indexOf('opera');
		navigator.family	= 'opera';
		navigator.org		= 'opera';
		navigator.version	= parseFloat('0' + ua.substr(i+6), 10);
	}
	else if ((i = ua.indexOf('msie')) != -1)
	{
		navigator.org		= 'microsoft';
		navigator.version	= parseFloat('0' + ua.substr(i+5), 10);
		
		if (navigator.version < 4)
			navigator.family = 'ie3';
		else
			navigator.family = 'ie4'
	}
	else if (typeof(window.controllers) != 'undefined' && typeof(window.locationbar) != 'undefined')
	{
		i = ua.lastIndexOf('/')
		navigator.version = parseFloat('0' + ua.substr(i+1), 10);
		navigator.family = 'gecko';

		if (ua.indexOf('netscape') != -1)
			navigator.org = 'netscape';
		else if (ua.indexOf('compuserve') != -1)
			navigator.org = 'compuserve';
		else
			navigator.org = 'mozilla';
	}
	else if ((ua.indexOf('mozilla') !=-1) && (ua.indexOf('spoofer')==-1) && (ua.indexOf('compatible') == -1) && (ua.indexOf('opera')==-1)&& (ua.indexOf('webtv')==-1) && (ua.indexOf('hotjava')==-1))
	{
	    var is_major = parseFloat(navigator.appVersion);
    
		if (is_major < 4)
			navigator.version = is_major;
		else
		{
			i = ua.lastIndexOf('/')
			navigator.version = parseFloat('0' + ua.substr(i+1), 10);
		}
		navigator.org = 'netscape';
		navigator.family = 'nn' + parseInt(navigator.appVersion);
	}
	else if ((i = ua.indexOf('aol')) != -1 )
	{
		// aol
		navigator.family	= 'aol';
		navigator.org		= 'aol';
		navigator.version	= parseFloat('0' + ua.substr(i+4), 10);
	}

	navigator.DOMCORE1	= (typeof(document.getElementsByTagName) != 'undefined' && typeof(document.createElement) != 'undefined');
	navigator.DOMCORE2	= (navigator.DOMCORE1 && typeof(document.getElementById) != 'undefined' && typeof(document.createElementNS) != 'undefined');
	navigator.DOMHTML	= (navigator.DOMCORE1 && typeof(document.getElementById) != 'undefined');
	navigator.DOMCSS1	= ( (navigator.family == 'gecko') || (navigator.family == 'ie4') );

	navigator.DOMCSS2   = false;
	if (navigator.DOMCORE1)
	{
		element = document.createElement('p');
	}

	navigator.DOMEVENTS	= (typeof(document.createEvent) != 'undefined');

	window.onerror = oldOnError;
}

detectBrowser();

function Folder(folderDescription, hreference) //constructor 
{ 
  //constant data 
  this.desc = folderDescription 
  this.hreference = hreference 
  this.id = -1   
  this.navObj = 0  
  this.iconImg = 0  
  this.nodeImg = 0  
  this.isLastNode = 0 
 
  //dynamic data 
  this.isOpen = true 
  this.iconSrc = "gfolderopen.gif"   
  this.children = new Array 
  this.nChildren = 0 
 
  //methods 
  this.initialize = initializeFolder 
  this.setState = setStateFolder 
  this.addChild = addChild 
  this.createIndex = createEntryIndex 
  this.escondeBlock = escondeBlock
  this.esconde = escondeFolder 
  this.mostra = mostra 
  this.renderOb = drawFolder 
  this.totalHeight = totalHeight 
  this.subEntries = folderSubEntries 
  this.outputLink = outputFolderLink 
  this.blockStart = blockStart
  this.blockEnd = blockEnd
} 
 
function initializeFolder(level, lastNode, leftSide) 
{ 
  var j=0 
  var i=0 
  var numberOfFolders 
  var numberOfDocs 
  var nc 
      
  nc = this.nChildren 
   
  this.createIndex() 
 
  var auxEv = "" 
 
  if (browserVersion > 0) 
    auxEv = "<a href='javascript:clickOnNode("+this.id+")'>" 
  else 
    auxEv = "<a>" 
 
  if (level>0) 
    if (lastNode) //the last child in the children array 
    { 
      this.renderOb(leftSide + auxEv + "<img name='nodeIcon" + this.id + "' id='nodeIcon" + this.id + "' src='gmlastnode.gif' width=16 height=22 border=0></a>") 
      leftSide = leftSide + "<img src='spacer.gif' width=16 height=22>"  
      this.isLastNode = 1 
    } 
    else 
    { 
      this.renderOb(leftSide + auxEv + "<img name='nodeIcon" + this.id + "' id='nodeIcon" + this.id + "' src='gmnode.gif' width=16 height=22 border=0></a>") 
      leftSide = leftSide + "<img src='gvertline.gif' width=16 height=22>" 
      this.isLastNode = 0 
    } 
  else 
    this.renderOb("") 
   
  if (nc > 0) 
  { 
    level = level + 1 
    for (i=0 ; i < this.nChildren; i++)  
    { 
      if (i == this.nChildren-1) 
        this.children[i].initialize(level, 1, leftSide) 
      else 
        this.children[i].initialize(level, 0, leftSide) 
      } 
  } 
} 
 
function setStateFolder(isOpen) 
{ 
  var subEntries 
  var totalHeight 
  var fIt = 0 
  var i=0 
 
  if (isOpen == this.isOpen) 
    return 
 
  if (browserVersion == 2)  
  { 
    totalHeight = 0 
    for (i=0; i < this.nChildren; i++) 
      totalHeight = totalHeight + this.children[i].navObj.clip.height 
      subEntries = this.subEntries() 
    if (this.isOpen) 
      totalHeight = 0 - totalHeight 
    for (fIt = this.id + subEntries + 1; fIt < nEntries; fIt++) 
      indexOfEntries[fIt].navObj.moveBy(0, totalHeight) 
  }  
  this.isOpen = isOpen 
  propagateChangesInState(this) 
} 
 
function propagateChangesInState(folder) 
{   
  var i=0 
 
  if (folder.isOpen) 
  { 
    if (folder.nodeImg) 
      if (folder.isLastNode) 
        folder.nodeImg.src = "gmlastnode.gif" 
      else 
	    folder.nodeImg.src = "gmnode.gif" 
    folder.iconImg.src = "gfolderopen.gif" 
    for (i=0; i<folder.nChildren; i++) 
      folder.children[i].mostra() 
  } 
  else 
  { 
    if (folder.nodeImg) 
      if (folder.isLastNode) 
        folder.nodeImg.src = "gplastnode.gif" 
      else 
	    folder.nodeImg.src = "gpnode.gif" 
    folder.iconImg.src = "gfolderclosed.gif"
    for (i=0; i<folder.nChildren; i++) 
      folder.children[i].esconde() 
  }  
} 
 
function escondeFolder() 
{ 
  this.escondeBlock()
   
  this.setState(0) 
} 
 
function drawFolder(leftSide) 
{ 
  var idParam = "id='folder" + this.id + "'"

  if (browserVersion == 2) { 
    if (!doc.yPos) 
      doc.yPos=20 
  } 

  this.blockStart("folder")
  doc.write("<tr id=x1><td>") 
  doc.write(leftSide) 
  this.outputLink() 
  doc.write("<img id='folderIcon" + this.id + "' name='folderIcon" + this.id + "' src='" + this.iconSrc+"' border=0></a>") 
  doc.write("</td><td valign=middle nowrap>") 
  doc.write("<font face=\"arial,helvetica,verdana,lucida,utopia\" COLOR=black>");
  if (USETEXTLINKS) 
  { 
    this.outputLink() 
    doc.write(this.desc + "</a>") 
  } 
  else 
    doc.write(this.desc) 
  doc.write("</td>")  

  this.blockEnd()
 
  if (browserVersion == 1) { 
    this.navObj = doc.all["folder"+this.id] 
    this.iconImg = doc.all["folderIcon"+this.id] 
    this.nodeImg = doc.all["nodeIcon"+this.id] 
  } else if (browserVersion == 2) { 
    this.navObj = doc.layers["folder"+this.id] 
    this.iconImg = this.navObj.document.images["folderIcon"+this.id] 
    this.nodeImg = this.navObj.document.images["nodeIcon"+this.id] 
    doc.yPos=doc.yPos+this.navObj.clip.height 
  } else if (browserVersion == 3) { 
    this.navObj = doc.getElementById("folder"+this.id)
    this.iconImg = doc.getElementById("folderIcon"+this.id) 
    this.nodeImg = doc.getElementById("nodeIcon"+this.id)
  } 
} 
 
function outputFolderLink() 
{ 
  if (this.hreference) 
  { 
    doc.write("<a href='" + this.hreference + "' TARGET=\"Main\" title=\"" + this.desc + "\" ") 
    if (browserVersion > 0) 
      doc.write("onClick='javascript:clickOnFolder("+this.id+")'") 
    doc.write(">") 
  } 
  else 
    doc.write("<a>") 
//  doc.write("<a href='javascript:clickOnFolder("+this.id+")'>")   
} 
 
function addChild(childNode) 
{ 
  this.children[this.nChildren] = childNode 
  this.nChildren++ 
  return childNode 
} 
 
function folderSubEntries() 
{ 
  var i = 0 
  var se = this.nChildren 
 
  for (i=0; i < this.nChildren; i++){ 
    if (this.children[i].children) //is a folder 
      se = se + this.children[i].subEntries() 
  } 
 
  return se 
} 
 
 
// Definition of class Item (a document or link inside a Folder) 
// ************************************************************* 
 
function Item(itemDescription, itemLink) // Constructor 
{ 
  // constant data 
  this.desc = itemDescription 
  this.link = itemLink 
  this.id = -1 //initialized in initalize() 
  this.navObj = 0 //initialized in render() 
  this.iconImg = 0 //initialized in render() 
  this.iconSrc = "gdoc.gif" 
 
  // methods 
  this.initialize = initializeItem 
  this.createIndex = createEntryIndex 
  this.esconde = escondeBlock
  this.mostra = mostra 
  this.renderOb = drawItem 
  this.totalHeight = totalHeight 
  this.blockStart = blockStart
  this.blockEnd = blockEnd
} 
 
function initializeItem(level, lastNode, leftSide) 
{  
  this.createIndex() 
 
  if (level>0) 
    if (lastNode) //the last 'brother' in the children array 
    { 
      this.renderOb(leftSide + "<img src='glastnode.gif' width=16 height=22>") 
      leftSide = leftSide + "<img src='spacer.gif' width=16 height=22>"  
    } 
    else 
    { 
      this.renderOb(leftSide + "<img src='gnode.gif' width=16 height=22>") 
      leftSide = leftSide + "<img src='gvertline.gif' width=16 height=22>" 
    } 
  else 
    this.renderOb("")   
} 
 
function drawItem(leftSide) 
{ 
  this.blockStart("item")

  doc.write("<tr id=x1><td>") 
  doc.write(leftSide) 
  if (this.link.length!=16) doc.write("<a href=" + this.link + ">") 
  doc.write("<img id='itemIcon"+this.id+"' ") 
  doc.write("src='"+this.iconSrc+"' border=0>") 
  if (this.link.length!=16) doc.write("</a>") 
  doc.write("</td><td valign=middle nowrap>") 
  doc.write("<font face=\"arial,helvetica,verdana,lucida,utopia\" COLOR=black>");
  if (this.link.length!=16) 
    doc.write("<a href=" + this.link + " title='" + this.desc + "'>" + this.desc + "</a>") 
  else 
    doc.write(this.desc) 

  this.blockEnd()
 
  if (browserVersion == 1) { 
    this.navObj = doc.all["item"+this.id] 
    this.iconImg = doc.all["itemIcon"+this.id] 
  } else if (browserVersion == 2) { 
    this.navObj = doc.layers["item"+this.id] 
    this.iconImg = this.navObj.document.images["itemIcon"+this.id] 
    doc.yPos=doc.yPos+this.navObj.clip.height 
  } else if (browserVersion == 3) { 
    this.navObj = doc.getElementById("item"+this.id)
    this.iconImg = doc.getElementById("itemIcon"+this.id)
  } 
} 
 
 
// Methods common to both objects (pseudo-inheritance) 
// ******************************************************** 
 
function mostra() 
{ 
  if (browserVersion == 1 || browserVersion == 3) 
    this.navObj.style.display = "block" 
  else 
    this.navObj.visibility = "show" 
} 

function escondeBlock() 
{ 
  if (browserVersion == 1 || browserVersion == 3) { 
    if (this.navObj.style.display == "none") 
      return 
    this.navObj.style.display = "none" 
  } else { 
    if (this.navObj.visibility == "hiden") 
      return 
    this.navObj.visibility = "hiden" 
  }     
} 
 
function blockStart(idprefix) {
  var idParam = "id='" + idprefix + this.id + "'"

  if (browserVersion == 2) 
    doc.write("<layer "+ idParam + " top=" + doc.yPos + " visibility=show>") 
     
  if (browserVersion == 3) //N6 has bug on display property with tables
    doc.write("<div " + idParam + " style='display:block; position:block;'>")
     
  doc.write("<table border=0 cellspacing=0 cellpadding=0 ") 

  if (browserVersion == 1) 
    doc.write(idParam + " style='display:block; position:block; '>") 
  else
    doc.write(">") 
}

function blockEnd() {
  doc.write("</table>") 
   
  if (browserVersion == 2) 
    doc.write("</layer>") 
  if (browserVersion == 3) 
    doc.write("</div>") 
}
 
function createEntryIndex() 
{ 
  this.id = nEntries 
  indexOfEntries[nEntries] = this 
  nEntries++ 
} 
 
// total height of subEntries open 
function totalHeight() //used with browserVersion == 2 
{ 
  var h = this.navObj.clip.height 
  var i = 0 
   
  if (this.isOpen) //is a folder and _is_ open 
    for (i=0 ; i < this.nChildren; i++)  
      h = h + this.children[i].totalHeight() 
 
  return h 
} 

 
// Events 
// ********************************************************* 
 
function clickOnFolder(folderId) 
{ 
  var clicked = indexOfEntries[folderId] 
 
  if (!clicked.isOpen) 
    clickOnNode(folderId) 
 
  return  
 
  if (clicked.isSelected) 
    return 
} 
 
function clickOnNode(folderId) 
{ 
  var clickedFolder = 0 
  var state = 0 
 
  clickedFolder = indexOfEntries[folderId] 
  state = clickedFolder.isOpen 
 
  clickedFolder.setState(!state) //open<->close  
} 
 

// Auxiliary Functions for Folder-Tree backward compatibility 
// *********************************************************** 
 
function gFld(description, hreference) 
{ 
  folder = new Folder(description, hreference) 
  return folder 
} 
 
function gLnk(target, description, linkData) 
{ 
  fullLink = "" 
 
  if (target==0) 
  { 
    fullLink = "'"+linkData+"' target=\"Main\"" 
  } 
  else 
  { 
    if (target==1) 
       fullLink = "'http://"+linkData+"' target=_blank" 
    else 
       fullLink = "'http://"+linkData+"' target=\"Main\"" 
  } 
 
  linkItem = new Item(description, fullLink)   
  return linkItem 
} 
 
function insFld(parentFolder, childFolder) 
{ 
  return parentFolder.addChild(childFolder) 
} 
 
function insDoc(parentFolder, document) 
{ 
  parentFolder.addChild(document) 
} 
 

// Global variables 
// **************** 
 
//These two variables are overwriten on defineMyTree.js if needed be
USETEXTLINKS = 0 
STARTALLOPEN = 0
indexOfEntries = new Array 
nEntries = 0 
doc = document 
browserVersion = 0 
selectedFolder=0


// Main function
// ************* 

// This function uses an object (navigator) defined in
// ua.js, imported in the main html page (left frame).
function initializeDocument() 
{ 
  switch(navigator.family)
  {
    case 'ie4':
      browserVersion = 1 //IE4   
      break;
    case 'nn4':
      browserVersion = 2 //NS4 
      break;
    case 'gecko':
      browserVersion = 3 //NS6
      break;
	default:
	  browserVersion = 0 //other 
	  break;
  }      

  //foldersTree (with the site's data) is created in an external .js 
  foldersTree.initialize(0, 1, "") 
  
  if (browserVersion == 2) 
    doc.write("<layer top="+indexOfEntries[nEntries-1].navObj.top+">&nbsp;</layer>") 

  //The tree starts in full display 
  if (!STARTALLOPEN)
	  if (browserVersion > 0) {
		// close the whole tree 
		clickOnNode(0) 
		// open the root folder 
		clickOnNode(0) 
	  } 

  if (browserVersion == 0) 
	doc.write("<table border=0><tr><td><br><br><font size=-1>This tree only expands or contracts with DHTML capable browsers</font></table>")
} 
 
USETEXTLINKS = 1  //replace 0 with 1 for hyperlinks
STARTALLOPEN = 0 //replace 0 with 1 to show the whole tree
