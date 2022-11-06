<!-- ======= Footer ======= --><footer id="footer">
<div class="footer-top">
  <div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-6 footer-info">
        <h3><?php echo conf('Name');?></h3>
        <p>
              中国,<?php echo conf_index('Index_Place') ?>
          <br>
          <br>
          <strong>电话:</strong> +86 <?php echo conf_index('Index_Phone') ?><br>
          <strong>邮箱:</strong> <?php echo conf_index('Index_Email') ?><br>
        </p>
        <div class="social-links mt-3">
            <a href="https://wpa.qq.com/msgrd?v=3&uin=<?php echo conf_index('Index_Qq') ?>&site=qq&menu=yes" class="QQ"><i class="NanFeng Icon-QQ" style="font-size: 24px;"></i></a>
            <a href="javascript:alert('暂未有此功能！');" class="weixin"><i class="NanFeng Icon-weixin" style="font-size: 24px;"></i></a>
            <a href="http://mail.qq.com/cgi-bin/qm_share?t=qm_mailme&email=<?php echo conf_index('Index_Email') ?>" class="youxiang"><i class="NanFeng Icon-youxiang" style="font-size: 24px;"></i></a>
        </div>
      </div>
      <div class="col-lg-2 col-md-6 footer-links">
        <h4>网站导航</h4>
        <ul>
          <li><i class="bx bx-chevron-right"></i><a href="#header">首页</a></li>
          <li><i class="bx bx-chevron-right"></i><a href="#about">关于</a></li>
          <li><i class="bx bx-chevron-right"></i><a href="#services">服务</a></li>
          <li><i class="bx bx-chevron-right"></i><a href="#portfolio">项目</a></li>
          <li><i class="bx bx-chevron-right"></i><a href="#team">成员</a></li>
          <li><i class="bx bx-chevron-right"></i><a href="#contact">联系</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-6 footer-links">
        <h4>友情链接</h4>
        <ul>
            <?php echo conf_index('Index_Links');?>
        </ul>
      </div>
      <div class="col-lg-4 col-md-6 footer-newsletter">
        <h4>新闻订阅</h4>
        <p>
          不善看邮箱者，请勿订阅！<br>订阅成功后将会发送一封邮件至您的邮箱！
        </p>
        <form>
          <input type="email" name="email1"><input type="submit" id="submit1" value="订阅">
        </form>
        <?php if(conf('Vaptcha_Open') == 1) {?>
        <br>
        <div id="vaptchaContainer">
            <div class="vaptcha-init-main">
                <div class="vaptcha-init-loading">
                    <a href="/" target="_blank">
                    <img src="https://r.vaptcha.com/public/img/vaptcha-loading.gif"/>
                    </a>
                    <span class="vaptcha-text">人机验证启动中...</span>
                </div>
            </div>
        </div>
      <?php }?>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class="copyright">
        Copyright &copy; 2018-2020 
    <strong><span><?php echo conf('Name') ?></span></strong>. All Rights Reserved
  </div>
  <div class="credits">
        Designed by 
    <a href="http://<?php echo conf('Url') ?>/"><?php echo conf('Name') ?></a>
  </div>
</div>
</footer><!-- End Footer --><a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a><!-- Vendor JS Files -->
<script src="assets/vendor/jquery/jquery.min.js"></script>
<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/jquery.easing/jquery.easing.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>
<script src="assets/vendor/jquery-sticky/jquery.sticky.js"></script>
<script src="assets/vendor/waypoints/jquery.waypoints.min.js"></script>
<script src="assets/vendor/counterup/counterup.min.js"></script>
<script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="assets/vendor/owl.carousel/owl.carousel.min.js"></script>
<script src="assets/vendor/venobox/venobox.min.js"></script>
<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>
<script src="assets/layer/layer.js"></script>
<?php if (conf_index('Index_Fang') == 1) {?>
<script src="assets/js/fang.js"></script>
<?php }?>
<?php echo conf_index('Index_Style');?>
<?php if(conf('Vaptcha_Open') == 1) {?>
<script src='https://v.vaptcha.com/v3.js'></script>
<script>
var obj;
vaptcha({
  vid: '<?php echo conf('Vaptcha_Vid')?>', 
  type: 'click', 
  scene: 0, 
  container: '#vaptchaContainer', 
  offline_server: '#', 
  lang: 'zh-CN',
  https: true,
  color: '#5c8af7'
}).then(function (vaptchaObj) {
  obj = vaptchaObj;
  vaptchaObj.render();
  vaptchaObj.listen('close', function () {
  })
})
</script>
<?php }?>
<script>
var vaptcha_open = 0;
$(document).ready(function(){
  if($("#vaptchaContainer").length>0) vaptcha_open=1;
  $("#submit1").click(function(){
    var email1=$("input[name='email1']").val();
    var data = {email:email1};
    var dy = $("button[type='submit']");
    if(email1==''){layer.msg('邮箱不能为空哦！');return false;}
    if(vaptcha_open==1){
      var token = obj.getToken();
      if(token == ""){
        layer.msg('请先完成人机验证！'); return false;
      }
      var adddata = {token:token};
    }
    dy.attr('disabled', 'true');
    layer.msg('正在提交中，请稍后...');
    $.ajax({
      type: "POST",
      url: "Ajax.php?act=subscribe",
      data: Object.assign(data, adddata),
      dataType: "json",
      success: function (data) {
        if (data.code == 1) {
          layer.alert(data.msg, {icon: 1}, function(){window.location.reload()});
        }else{
          dy.removeAttr('disabled');
          layer.alert(data.msg, {icon: 2});
          obj.reset();
        }
      },
    });
    return false;
  });
  $("#Query").click(function(){
    layer.open({
      type: 2,
      title: '成员查询',
      shadeClose: true,
      scrollbar: false,
      shade: false,
      area: ['312px','298px'],
      content: '/indexs.php?my=Query'
    });
  });
  $("#Join").click(function(){
    layer.open({
      type: 2,
      title: '申请加入',
      shadeClose: true,
      scrollbar: false,
      shade: false,
      maxmin: true,
      area: ['312px', '428px'],
      content: '/indexs.php?my=Join'
    });
  })
});
</script>
</body>
</html>