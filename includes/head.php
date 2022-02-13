<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--Less styles -->
<!-- Other Less css file //different less files has different color scheam
	<link rel="stylesheet/less" type="text/css" href="themes/less/simplex.less">
	<link rel="stylesheet/less" type="text/css" href="themes/less/classified.less">
	<link rel="stylesheet/less" type="text/css" href="themes/less/amelia.less">  MOVE DOWN TO activate
	-->
<!--<link rel="stylesheet/less" type="text/css" href="themes/less/bootshop.less">
	<script src="themes/js/less.js" type="text/javascript"></script> -->

<!-- Bootstrap style -->
<link id="callCss" rel="stylesheet" href="themes/cerulean/bootstrap.min.css" media="screen" />
<link href="themes/css/base.css?v=<?php echo time(); ?>" rel="stylesheet" media="screen" />
<!-- Bootstrap style responsive -->
<!-- <link href="themes/css/bootstrap.min.css?v=<?php echo time(); ?>" rel="stylesheet" /> -->

<link href="themes/css/bootstrap-responsive.min.css?v=<?php echo time(); ?>" rel="stylesheet" />

<link href="themes/css/font-awesome.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css">
<!-- Google-code-prettify -->
<link href="themes/js/google-code-prettify/prettify.css?v=<?php echo time(); ?>" rel="stylesheet" />
<!-- fav and touch icons -->
<link rel="shortcut icon" href="themes/images/ico/favicon.ico">
<link rel="apple-touch-icon-precomposed" sizes="144x144" href="themes/images/ico/apple-touch-icon-144-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="themes/images/ico/apple-touch-icon-114-precomposed.png">
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="themes/images/ico/apple-touch-icon-72-precomposed.png">
<link rel="apple-touch-icon-precomposed" href="themes/images/ico/apple-touch-icon-57-precomposed.png">
<style type="text/css" id="enject"></style>
<script>
	const formater = new Intl.NumberFormat('en-NG', {
		style: 'currency',
		currency: 'NGN',
		maximumFractionDigits: 0,
	})

	function nairaFormat(number) {
		//console.log('inside nairaFormat function')
		//document.write('₦'.number)
		if (formater.format(number) != null) {
			document.write(formater.format(number));
		} else {
			document.write(number);
		}
		//return '₦'.formater.format(number);
	}

	function nairaFormatR(number) {
		//console.log('inside nairaFormat function')
		//document.write(formater.format(number));
		//return '₦'.number;
		if (formater.format(number) != null) {
			return formater.format(number);
		} else {
			return '₦'.number;
		}
	}
</script>