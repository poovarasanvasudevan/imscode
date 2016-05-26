

function init()
{
	for (var i=0; i<fo_obj_queue.length; i++)
	{
		var f = fo_obj_queue[i];
		if (swfobject.hasFlashPlayerVersion(f.version))
		
			swfobject.embedSWF(f.file, f.replace, f.width, f.height, f.version, null, f.flashvars, f.params, f.attributes);
		else
			document.getElementById(f.replace).innerHTML = '<table align="center"><tr><td><div style="color:gray; padding: 80px 0 0 0;"><a href="http://www.adobe.com/go/getflash"><img src="/content/framework/images/noflash.gif" border="0" /></a></div></td></tr></table>';
	}
}

var fo_obj_queue = new Array();

function enqueue(obj)
{
    
	fo_obj_queue[fo_obj_queue.length] = obj;
}
