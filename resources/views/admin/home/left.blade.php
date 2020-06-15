@include("admin.home.head")

	<div class="main-container" id="main-container">
		<script type="text/javascript">
			try{ace.settings.check('main-container' , 'fixed')}catch(e){}
		</script>

		<div class="main-container-inner">
			<a class="menu-toggler" id="menu-toggler" href="#">
				<span class="menu-text"></span>
			</a>

			<!-- 左侧菜单 -->
			<div class="sidebar" id="sidebar">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>
				<!-- 左侧菜单上方样式 -->
				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						<a class="btn btn-success">
							<i class="icon-signal"></i>
						</a>
						<a class="btn btn-info">
							<i class="icon-pencil"></i>
						</a>
						<a class="btn btn-warning">
							<i class="icon-group"></i>
						</a>
						<a class="btn btn-danger">
							<i class="icon-cogs"></i>
						</a>
					</div>
					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>
						<span class="btn btn-info"></span>
						<span class="btn btn-warning"></span>
						<span class="btn btn-danger"></span>
					</div>
				</div>
				<!-- 左侧菜单 -->
				<div id="menu_style" class="menu_style">
					<ul class="nav nav-list" id="nav_list">
						<li class="home"><a href="javascript:void(0)" name="/admin/home" class="iframeurl" title=""><i class="icon-home"></i><span class="menu-text"> 系统首页 </span></a></li>
						<li><a href="#" class="dropdown-toggle"><i class="icon-desktop"></i><span class="menu-text"> 商品管理 </span><b class="arrow icon-angle-down"></b></a>
							<ul class="submenu">
								<li class="home"><a href="javascript:void(0)" name="/admin/sort" title="分类管理"  class="iframeurl"><i class="icon-double-angle-right"></i>分类管理</a></li>
								<li class="home"><a  href="javascript:void(0)" name="/admin/goods"  title="商品列表" class="iframeurl"><i class="icon-double-angle-right"></i>商品列表</a></li>
							</ul>
						</li>
						<li>
							<a href="#" class="dropdown-toggle"><i class="icon-picture "></i><span class="menu-text"> 图片管理 </span><b class="arrow icon-angle-down"></b></a>
							<ul class="submenu">
								<li class="home"><a href="javascript:void(0)" name="advertising.html" title="广告管理" class="iframeurl"><i class="icon-double-angle-right"></i>广告管理</a></li>
								<li class="home"><a href="javascript:void(0)" name="Sort_ads.html" title="分类管理"  class="iframeurl"><i class="icon-double-angle-right"></i>分类管理</a></li>
							</ul>
						</li>
						<li>
							<a href="#" class="dropdown-toggle"><i class="icon-list"></i><span class="menu-text"> 交易管理 </span><b class="arrow icon-angle-down"></b></a>
							<ul class="submenu">
								<li class="home"><a href="javascript:void(0)" name="transaction.html" title="交易信息"  class="iframeurl"><i class="icon-double-angle-right"></i>交易信息</a></li>
								<li class="home"><a href="javascript:void(0)" name="Order_Chart.html" title="交易订单（图）"  class="iframeurl"><i class="icon-double-angle-right"></i>交易订单(图)</a></li>
								<li class="home"><a href="javascript:void(0)" name="Orderform.html" title="订单管理"  class="iframeurl"><i class="icon-double-angle-right"></i>订单管理</a></li>
								<li class="home"><a href="javascript:void(0)" name="Amounts.html" title="交易金额"  class="iframeurl"><i class="icon-double-angle-right"></i>交易金额</a></li>
								<li class="home"><a href="javascript:void(0)" name="Order_handling.html" title="订单处理"  class="iframeurl"><i class="icon-double-angle-right"></i>订单处理</a></li>
								<li class="home"><a href="javascript:void(0)" name="Refund.html" title="退款管理"  class="iframeurl"><i class="icon-double-angle-right"></i>退款管理</a></li>
							</ul>
						</li>
						<li>
							<a href="#" class="dropdown-toggle"><i class="icon-credit-card"></i><span class="menu-text"> 支付管理 </span><b class="arrow icon-angle-down"></b></a>
							<ul class="submenu">
								<li class="home"><a href="javascript:void(0)" name="Cover_management.html" title="账户管理" class="iframeurl"><i class="icon-double-angle-right"></i>账户管理</a></li>
								<li class="home"><a href="javascript:void(0)" name="payment_method.html" title="支付方式" class="iframeurl"><i class="icon-double-angle-right"></i>支付方式</a></li>
								<li class="home"><a href="javascript:void(0)" name="Payment_Configure.html" title="支付配置" class="iframeurl"><i class="icon-double-angle-right"></i>支付配置</a></li>
							</ul>
						</li>
						<li>
							<a href="#" class="dropdown-toggle"><i class="icon-user"></i><span class="menu-text"> 会员管理 </span><b class="arrow icon-angle-down"></b></a>
							<ul class="submenu">
								<li class="home"><a href="javascript:void(0)" name="/admin/member" title="会员列表"  class="iframeurl"><i class="icon-double-angle-right"></i>会员列表</a></li>

							</ul>
						</li>
						<li><a href="#" class="dropdown-toggle"><i class="icon-laptop"></i><span class="menu-text"> 店铺管理 </span><b class="arrow icon-angle-down"></b></a>
							<ul class="submenu">
								<li class="home"><a href="javascript:void(0)" name="Shop_list.html" title="店铺列表" class="iframeurl"><i class="icon-double-angle-right"></i>店铺列表</a></li>
								<li class="home"><a href="javascript:void(0)" name="Shops_Audit.html" title="店铺审核" class="iframeurl"><i class="icon-double-angle-right"></i>店铺审核<span class="badge badge-danger">5</span></a></li>
							</ul>
						</li>
						<li><a href="#" class="dropdown-toggle"><i class="icon-comments-alt"></i><span class="menu-text"> 消息管理 </span><b class="arrow icon-angle-down"></b></a>
							<ul class="submenu">
								<li class="home"><a href="javascript:void(0)" name="Guestbook.html" title="留言列表" class="iframeurl"><i class="icon-double-angle-right"></i>留言列表</a></li>
								<li class="home"><a href="javascript:void(0)" name="Feedback.html" title="意见反馈" class="iframeurl"><i class="icon-double-angle-right"></i>意见反馈</a></li>
							</ul>
						</li>
						<li><a href="#" class="dropdown-toggle"><i class="icon-bookmark"></i><span class="menu-text"> 文章管理 </span><b class="arrow icon-angle-down"></b></a>
							<ul class="submenu">
								<li class="home"><a href="javascript:void(0)" name="article_list.html" title="文章列表" class="iframeurl"><i class="icon-double-angle-right"></i>文章列表</a></li>
								<li class="home"><a href="javascript:void(0)" name="article_Sort.html" title="分类管理" class="iframeurl"><i class="icon-double-angle-right"></i>分类管理</a></li>
							</ul>
						</li>
						<li><a href="#" class="dropdown-toggle"><i class="icon-cogs"></i><span class="menu-text"> 系统管理 </span><b class="arrow icon-angle-down"></b></a>
							<ul class="submenu">
								<li class="home"><a href="javascript:void(0)" name="/admin/date" title="日期设置" class="iframeurl"><i class="icon-double-angle-right"></i>日期设置</a></li>
								<li class="home"><a href="javascript:void(0)" name="System_Logs.html" title="系统日志" class="iframeurl"><i class="icon-double-angle-right"></i>系统日志</a></li>
							</ul>
						</li>
						<li><a href="#" class="dropdown-toggle"><i class="icon-group"></i><span class="menu-text"> 管理员管理 </span><b class="arrow icon-angle-down"></b></a>
							<ul class="submenu">
								<li class="home"><a href="javascript:void(0)" name="/admin/user" title="管理员列表" class="iframeurl"><i class="icon-double-angle-right"></i>管理员列表</a></li>
							</ul>
						</li>
					</ul>
				</div>
				<!-- 左侧下方缩进 -->
				<script type="text/javascript">
				   $("#menu_style").niceScroll({
					cursorcolor:"#888888",
					cursoropacitymax:1,
					touchbehavior:false,
					cursorwidth:"5px",
					cursorborder:"0",
					cursorborderradius:"5px"
					});
				</script>
				<div class="sidebar-collapse" id="sidebar-collapse">
					<i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
				</div>
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>

			<!-- 右侧内容 -->
			<div class="main-content">
				<!-- 右侧上方内容 -->
				<script type="text/javascript">
					try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
				</script>
				<div class="breadcrumbs" id="breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="icon-home home-icon"></i>
							<a href="/admin/index">首页</a>
						</li>
						<li class="active"><span class="Current_page iframeurl"></span></li>
						<li class="active" id="parentIframe"><span class="parentIframe iframeurl"></span></li>
						<li class="active" id="parentIfour"><span class="parentIfour iframeurl"></span></li>
					</ul>
				</div>

				<!-- 右侧中间内容 -->
				<iframe id="iframe" style="border:0; width:100%; background-color:#FFF;" name="iframe" frameborder="0" src="/admin/home" >
				</iframe>

			</div>

		</div>

	</div>


@include("admin.home.footer")
