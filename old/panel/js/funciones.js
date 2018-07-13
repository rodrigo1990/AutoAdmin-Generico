function getPageWidth()
{
	var viewportwidth;

	if(typeof window.innerWidth != 'undefined')
	{
		viewportwidth = window.innerWidth;
	}
	else if(typeof document.documentElement != 'undefined' && typeof document.documentElement.clientWidth != 'undefined' && document.documentElement.clientWidth != 0)
	{
		viewportwidth = document.documentElement.clientWidth;
	}
	else
	{
		viewportwidth = document.getElementsByTagName('body')[0].clientWidth;
	}
	
	return viewportwidth;
}

function getPageHeight()
{
	var viewportheight;

	if(typeof window.innerHeight != 'undefined')
	{
		viewportheight = window.innerHeight;
	}
	else if(typeof document.documentElement != 'undefined' && typeof document.documentElement.clientHeight != 'undefined' && document.documentElement.clientHeight != 0)
	{
		viewportheight = document.documentElement.clientHeight;
	}
	else
	{
		viewportheight = document.getElementsByTagName('body')[0].clientHeight;
	}
	
	return viewportheight;
}

function resizePage()
{
	$('#cuerpo_index_panel').css('height', (getPageHeight()-parseInt($('#logo').css('height'))-20)+'px');
}

function resizePage2()
{
	$('#cuerpo_tipo_cursos_panel').css('height', (getPageHeight()-parseInt($('#logo').css('height'))-50)+'px');
}

function resizePage3()
{
	$('#nutricion').css('height', (getPageHeight()-parseInt($('#logo').css('height'))-225)+'px');
}

function resizePage4()
{
	$('#cuerpo_listado_recetas_panel').css('height', (getPageHeight()-parseInt($('#logo').css('height'))-50)+'px');
}