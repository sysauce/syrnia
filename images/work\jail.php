<html>	
	<head>
		<title>Syrnia Jail</title>
		<script language='VBScript'>
		function DetectUnityWebPlayerActiveX
			on error resume next
			dim tControl
			dim res
			res = 0
			set tControl = CreateObject("UnityWebPlayer.UnityWebPlayer.1")
			if IsObject(tControl) then
				res = 1
			end if
			DetectUnityWebPlayerActiveX = res
		end function
		</script>
		<script language="javascript1.1" type="text/javascript">
		
			function GetUnity () {
				if (navigator.appVersion.indexOf("MSIE") != -1 && navigator.appVersion.toLowerCase().indexOf("win") != -1)
					return document.getElementById("UnityObject");
				else if (navigator.appVersion.toLowerCase().indexOf("safari") != -1)
					return document.getElementById("UnityObject");
				else
					return document.getElementById("UnityEmbed");
			}
			
			function DetectUnityWebPlayer () {
        		var tInstalled = false;
        		if (navigator.appVersion.indexOf("MSIE") != -1 && navigator.appVersion.toLowerCase().indexOf("win") != -1) {
					tInstalled = DetectUnityWebPlayerActiveX();
        		}
        		else {
            		if (navigator.mimeTypes && navigator.mimeTypes["application/vnd.unity"]) {
                		if (navigator.mimeTypes["application/vnd.unity"].enabledPlugin && navigator.plugins && navigator.plugins["Unity Player"]) {
                 			tInstalled = true;	
            			}
         			}	
        		}
        		return tInstalled;	
    		}
    		
    		function GetInstallerPath () {
    			var tDownloadURL = "";
	   			var hasXpi = navigator.userAgent.toLowerCase().indexOf( "firefox" ) != -1;
	   			
    			// Use standalone installer
    			if (1)
    			{
					if (navigator.platform == "MacIntel")
						tDownloadURL = "http://webplayer.unity3d.com/download_webplayer-2.x/webplayer-i386.dmg";
					else if (navigator.platform == "MacPPC")
						tDownloadURL = "http://webplayer.unity3d.com/download_webplayer-2.x/webplayer-ppc.dmg";
					else if (navigator.platform.toLowerCase().indexOf("win") != -1)
						tDownloadURL = "http://webplayer.unity3d.com/download_webplayer-2.x/UnityWebPlayer.exe";
					return tDownloadURL;
    			}
    			// Use XPI installer
				else
				{
					if (navigator.platform == "MacIntel")
						tDownloadURL = "http://webplayer.unity3d.com/download_webplayer-2.x/UnityWebPlayerOSX.xpi";
					else if (navigator.platform == "MacPPC")
						tDownloadURL = "http://webplayer.unity3d.com/download_webplayer-2.x/UnityWebPlayerOSX.xpi";
					else if (navigator.platform.toLowerCase().indexOf("win") != -1)
						tDownloadURL = "http://webplayer.unity3d.com/download_webplayer-2.x/UnityWebPlayerWin32.xpi";
					return tDownloadURL;
				}    			
    		}
			
			function AutomaticReload () {
				navigator.plugins.refresh();
				if (DetectUnityWebPlayer())
					window.location.reload();

				setTimeout('AutomaticReload()', 500)
			}
			
		</script>
	</head>

	<body bgcolor=#000000><center>
	<table height=100%>
	<tr><td> </td></tr>
	<tr height=600><td height=600>
		<center>

				<script language="javascript1.1" type="text/javaScript">
				
				if (DetectUnityWebPlayer()) {
					
					document.write('<object id="UnityObject" classid="clsid:444785F1-DE89-4295-863A-D46C3A781394" width="800" height="600"> \n');
					document.write('  <param name="src" value="jail.unity3d" /> \n');					
					document.write('  <param name="disableContextMenu" value="true" /> \n');					
					document.write('  <param name="logoimage" value="jail.png" /> \n');
					document.write('  <param name="backgroundcolor" value="000000" /><param name="bordercolor" value="000000" />  \n');
					document.write('  <embed id="UnityEmbed" src="jail.unity3d" disableContextMenu=true  width="800" logoimage="jail.png" backgroundcolor="000000" bordercolor="000000"  height="600" type="application/vnd.unity" pluginspage="http://www.unity3d.com/unity-web-player-2.x" /> \n');
					document.write('</object>');
				}
				else {
				
					var installerPath = GetInstallerPath();
					if (installerPath != "") {
						// Place a link to the right installer depending on the platform we are on. The iframe is very important! Our goals are:
						// 1. Don't have to popup new page
						// 2. This page still remains active, so our automatic reload script will refresh the page when the plugin is installed
						document.write('<div align="center" id="UnityPrompt"> \n');
						document.write('  <a href= ' + installerPath + '><img src="http://webplayer.unity3d.com/installation/getunity.png" border="0"/></a> \n');
						document.write('</div> \n');
						
						// By default disable ActiveX cab installation, because we can't make a nice Install Now button
//						if (navigator.appVersion.indexOf("MSIE") != -1 && navigator.appVersion.toLowerCase().indexOf("win") != -1)
						if (0)
						{	
							document.write('<div id="InnerUnityPrompt"> <p>Title</p>');
							document.write('<p> Contents</p>');
							document.write("</div>");

							var innerUnityPrompt = document.getElementById("InnerUnityPrompt");
							
							var innerHtmlDoc =
								'<object id="UnityInstallerObject" classid="clsid:444785F1-DE89-4295-863A-D46C3A781394" width="320" height="50" codebase="http://webplayer.unity3d.com/download_webplayer-2.x/UnityWebPlayer.cab#version=2,0,0,0">\n' + 
							    '</object>';
							    
							innerUnityPrompt.innerHTML = innerHtmlDoc;
						}

						document.write('<iframe name="InstallerFrame" height="0" width="0" frameborder="0">\n');
					}
					else {
						document.write('<div align="center" id="UnityPrompt"> \n');
						document.write('  <a href="javascript: window.open("http://www.unity3d.com/unity-web-player-2.x"); "><img src="http://webplayer.unity3d.com/installation/getunity.png" border="0"/></a> \n');
						document.write('</div> \n');
					}
					
					AutomaticReload();
				}
			
			</script>
			<noscript>
				<object id="UnityObject" classid="clsid:444785F1-DE89-4295-863A-D46C3A781394" width="800" height="600" codebase="http://webplayer.unity3d.com/download_webplayer-2.x/UnityWebPlayer.cab#version=2,0,0,0">
					<param name="src" value="jail.unity3d" />
					<embed id="UnityEmbed" src="music.unity3d" backgroundcolor="#000000" bordercolor="#000000" width="800" height="600" type="application/vnd.unity" pluginspage="http://www.unity3d.com/unity-web-player-2.x" />
					<noembed>
						<div align="center">
							This content requires the Unity Web Player<br /><br />
							<a href="http://www.unity3d.com/unity-web-player-2.x">Install the Unity Web Player today!</a>
						</div>
					</noembed>
				</object>
			</noscript>
		</center>
		</td></tr>
		<tr><td> </td></tr></table></center>
	</body>	
</html>