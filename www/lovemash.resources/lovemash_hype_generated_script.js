//	HYPE.documents["lovemash"]

(function HYPE_DocumentLoader() {
	var resourcesFolderName = "lovemash.resources";
	var documentName = "lovemash";
	var documentLoaderFilename = "lovemash_hype_generated_script.js";
	var mainContainerID = "lovemash_hype_container";

	// find the URL for this script's absolute path and set as the resourceFolderName
	try {
		var scripts = document.getElementsByTagName('script');
		for(var i = 0; i < scripts.length; i++) {
			var scriptSrc = scripts[i].src;
			if(scriptSrc != null && scriptSrc.indexOf(documentLoaderFilename) != -1) {
				resourcesFolderName = scriptSrc.substr(0, scriptSrc.lastIndexOf("/"));
				break;
			}
		}
	} catch(err) {	}

	// Legacy support
	if (typeof window.HYPE_DocumentsToLoad == "undefined") {
		window.HYPE_DocumentsToLoad = new Array();
	}
 
	// load HYPE.js if it hasn't been loaded yet
	if(typeof HYPE_150 == "undefined") {
		if(typeof window.HYPE_150_DocumentsToLoad == "undefined") {
			window.HYPE_150_DocumentsToLoad = new Array();
			window.HYPE_150_DocumentsToLoad.push(HYPE_DocumentLoader);

			var headElement = document.getElementsByTagName('head')[0];
			var scriptElement = document.createElement('script');
			scriptElement.type= 'text/javascript';
			scriptElement.src = resourcesFolderName + '/' + 'HYPE.js?hype_version=150';
			headElement.appendChild(scriptElement);
		} else {
			window.HYPE_150_DocumentsToLoad.push(HYPE_DocumentLoader);
		}
		return;
	}
	
	// handle attempting to load multiple times
	if(HYPE.documents[documentName] != null) {
		var index = 1;
		var originalDocumentName = documentName;
		do {
			documentName = "" + originalDocumentName + "-" + (index++);
		} while(HYPE.documents[documentName] != null);
		
		var allDivs = document.getElementsByTagName("div");
		var foundEligibleContainer = false;
		for(var i = 0; i < allDivs.length; i++) {
			if(allDivs[i].id == mainContainerID && allDivs[i].getAttribute("HYPE_documentName") == null) {
				var index = 1;
				var originalMainContainerID = mainContainerID;
				do {
					mainContainerID = "" + originalMainContainerID + "-" + (index++);
				} while(document.getElementById(mainContainerID) != null);
				
				allDivs[i].id = mainContainerID;
				foundEligibleContainer = true;
				break;
			}
		}
		
		if(foundEligibleContainer == false) {
			return;
		}
	}
	
	var hypeDoc = new HYPE_150();
	
	var attributeTransformerMapping = {b:"i",c:"i",bC:"i",d:"i",aS:"i",M:"i",e:"f",N:"i",f:"d",aT:"i",O:"i",g:"c",aU:"i",P:"i",Q:"i",aV:"i",R:"c",bG:"f",aW:"f",aI:"i",S:"i",bH:"d",l:"d",aX:"i",aJ:"i",m:"c",bI:"f",T:"i",n:"c",aK:"i",bJ:"f",aZ:"i",X:"i",A:"c",bK:"f",Y:"bM",B:"c",aL:"i",bL:"f",C:"c",D:"c",t:"i",E:"i",G:"c",bA:"c",a:"i",bB:"i"};
	
	var resources = {"3":{n:"lightbulb.png",p:1},"1":{n:"friend1.png",p:1},"4":{n:"lovemash.png",p:1},"2":{n:"friend2.png",p:1},"0":{n:"user.png",p:1}};
	
	var scenes = [{x:0,p:"600px",c:"#FFFFFF",v:{"7":{o:"content-box",h:"2",x:"visible",a:304,q:"100% 100%",b:16,j:"absolute",r:"inline",c:57,k:"div",z:"6",d:112,e:"0.000000"},"3":{aV:8,w:"You",x:"visible",a:177,Z:"break-word",b:139,j:"absolute",r:"inline",y:"preserve",k:"div",z:"3",aT:8,aS:8,F:"center",e:"1.000000",t:16,G:"#000000",aU:8},"8":{aU:8,G:"#000000",c:68,aV:8,r:"inline",d:18,e:"0.000000",t:16,Z:"break-word",w:"Friend 2",j:"absolute",x:"visible",k:"div",y:"preserve",z:"7",aS:8,aT:8,a:291,F:"center",b:127},"4":{o:"content-box",h:"0",x:"visible",a:149,q:"100% 100%",b:21,j:"absolute",r:"inline",c:101,k:"div",z:"2",d:118,e:"1.000000"},"9":{o:"content-box",h:"3",x:"visible",a:189,q:"100% 100%",b:7,j:"absolute",r:"inline",c:35,k:"div",z:"8",d:34,e:"0.000000"},"5":{o:"content-box",h:"1",x:"visible",a:45,q:"100% 100%",b:16,j:"absolute",r:"inline",c:58,k:"div",z:"4",d:112,e:"0.000000"},"6":{aU:8,G:"#000000",c:68,aV:8,r:"inline",d:18,e:"0.000000",t:16,Z:"break-word",w:"Friend 1",j:"absolute",x:"visible",k:"div",y:"preserve",z:"5",aS:8,aT:8,a:32,F:"center",b:128},"10":{o:"content-box",h:"4",x:"visible",a:104,q:"100% 100%",b:0,j:"absolute",r:"inline",c:195,k:"div",z:"9",d:195,e:"0.000000"}},n:"Untitled Scene",T:{kTimelineDefaultIdentifier:{d:7,i:"kTimelineDefaultIdentifier",n:"Main Timeline",a:[{f:"2",t:0,d:2.15,i:"w",e:"Friend 1",s:"Friend 1",o:"6"},{f:"2",t:0,d:6,i:"e",e:"0.000000",s:"0.000000",o:"10"},{f:"2",t:0,d:1.15,i:"e",e:"0.000000",s:"1.000000",o:"3"},{f:"2",t:0,d:1.15,i:"b",e:41,s:21,o:"4"},{f:"2",t:1.15,d:1,i:"e",e:"1.000000",s:"0.000000",o:"6"},{f:"2",t:1.15,d:1,i:"e",e:"1.000000",s:"0.000000",o:"5"},{f:"2",t:2.15,d:1,i:"e",e:"1.000000",s:"0.000000",o:"7"},{f:"2",t:2.15,d:1,i:"e",e:"1.000000",s:"0.000000",o:"8"},{f:"2",t:2.15,d:1.15,i:"e",e:"1.000000",s:"1.000000",o:"6"},{f:"2",t:2.15,d:3.15,i:"e",e:"1.000000",s:"1.000000",o:"5"},{f:"2",t:3.15,d:0.15,i:"e",e:"1.000000",s:"0.000000",o:"9"},{f:"2",t:3.15,d:2.15,i:"e",e:"1.000000",s:"1.000000",o:"7"},{f:"2",t:3.15,d:0.15,i:"e",e:"1.000000",s:"1.000000",o:"8"},{f:"2",t:4,d:0.15,i:"e",e:"1.000000",s:"1.000000",o:"9"},{f:"2",t:4,d:0.15,i:"e",e:"0.000000",s:"1.000000",o:"6"},{f:"2",t:4,d:0.15,i:"e",e:"0.000000",s:"1.000000",o:"8"},{f:"2",t:4.15,d:1,i:"a",e:202,s:304,o:"7"},{f:"2",t:4.15,d:1,i:"a",e:129,s:45,o:"5"},{f:"2",t:4.15,d:0.15,i:"e",e:"0.000000",s:"1.000000",o:"4"},{f:"2",t:4.15,d:1,i:"a",e:116,s:32,o:"6"},{f:"2",t:4.15,d:1,i:"b",e:139,s:128,o:"6"},{f:"2",t:4.15,d:1,i:"b",e:27,s:16,o:"5"},{f:"2",t:4.15,d:1,i:"a",e:189,s:291,o:"8"},{f:"2",t:4.15,d:1,i:"b",e:138,s:127,o:"8"},{f:"2",t:4.15,d:1,i:"b",e:27,s:16,o:"7"},{f:"2",t:4.15,d:0.15,i:"e",e:"0.000000",s:"1.000000",o:"9"},{f:"2",t:6,d:1,i:"d",e:123,s:195,o:"10"},{f:"2",t:6,d:1,i:"b",e:36,s:0,o:"10"},{f:"2",t:6,d:1,i:"a",e:140,s:104,o:"10"},{f:"2",t:6,d:1,i:"c",e:123,s:195,o:"10"},{f:"2",t:6,d:1,i:"e",e:"1.000000",s:"0.000000",o:"10"},{f:"2",t:6,d:0.15,i:"e",e:"0.000000",s:"1.000000",o:"7"},{f:"2",t:6,d:0.15,i:"e",e:"0.000000",s:"1.000000",o:"5"}],f:30}},o:"1"}];
	
	var javascripts = [];
	
	var functions = {};
	var javascriptMapping = {};
	for(var i = 0; i < javascripts.length; i++) {
		try {
			javascriptMapping[javascripts[i].identifier] = javascripts[i].name;
			eval("functions." + javascripts[i].name + " = " + javascripts[i].source);
		} catch (e) {
			hypeDoc.log(e);
			functions[javascripts[i].name] = (function () {});
		}
	}
	
	hypeDoc.setAttributeTransformerMapping(attributeTransformerMapping);
	hypeDoc.setResources(resources);
	hypeDoc.setScenes(scenes);
	hypeDoc.setJavascriptMapping(javascriptMapping);
	hypeDoc.functions = functions;
	hypeDoc.setCurrentSceneIndex(0);
	hypeDoc.setMainContentContainerID(mainContainerID);
	hypeDoc.setResourcesFolderName(resourcesFolderName);
	hypeDoc.setShowHypeBuiltWatermark(0);
	hypeDoc.setShowLoadingPage(true);
	hypeDoc.setDrawSceneBackgrounds(false);
	hypeDoc.setGraphicsAcceleration(true);
	hypeDoc.setDocumentName(documentName);

	HYPE.documents[documentName] = hypeDoc.API;
	document.getElementById(mainContainerID).setAttribute("HYPE_documentName", documentName);

	hypeDoc.documentLoad(this.body);
}());

