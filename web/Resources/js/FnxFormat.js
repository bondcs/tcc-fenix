(function($){
    $.fn.fnxFormat = function(options){
	debug(this);

	var opts = $.extend({}, $.fn.fnxFormat.defaults, options);
	return this.each(function() {
	    $this = $(this);
	    // constrói opções específicas do elemento
	    var o = $.meta ? $.extend({}, opts, $this.data()) : opts;
	    // fomata ao sair do elemento
	    // e desformata ao entrar
	    $this.live('blur',function(){
		if($(this).val() != '')
		    $(this).val(formataDinheiro($(this).val()));
	    }).live('focus', function(){
		if($(this).val() != '')
		    $(this).val(desformataDinheiro($(this).val()));
	    });
	});
    };

    debug = function(elem){
	console.log('elementos a serem formatados: '+elem);
    }

    $.fn.fnxFormat.format = function(value) {
	if($(value) === undefined)
	    return desformataDinheiro($(this).text());
	else{
	    $(this).text(formataDinheiro(value));
	    return $(this);
	}
    };

    number_format = function(number, decimals, dec_point, thousands_sep) {
	number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
	var n = !isFinite(+number) ? 0 : +number,
	prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
	sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
	dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
	s = '',
	toFixedFix = function (n, prec) {
	    var k = Math.pow(10, prec);
	    return '' + Math.round(n * k) / k;
	};
	// Fix for IE parseFloat(0.55).toFixed(0) = 0;
	s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
	if (s[0].length > 3) {
	    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	}
	if ((s[1] || '').length < prec) {
	    s[1] = s[1] || '';
	    s[1] += new Array(prec - s[1].length + 1).join('0');
	}
	return s.join(dec);
    }

    formataDinheiro = function(value){
	return "R$ " + number_format(value.replace(',','.'), 2, ',','');
    }

    desformataDinheiro = function(value){
	return value.replace(",", ".").slice(3) * 1;
    }
})(jQuery);