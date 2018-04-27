<?php
/**
 * @Author: Marte
 * @Date:   2018-04-26 19:21:36
 * @Last Modified by:   Marte
 * @Last Modified time: 2018-04-27 09:58:17
 */
namespace app\admin\controller;
use think\Request;
use think\Controller;
use think\Db;
use phpmailer\phpmailer;
class Message extends Controller
{


    public function showmsg(){
            $page = input("get.page",1);
            $size = 2;
            $offset = ($page-1)*$size;
            $sql1  = "SELECT count(*) as num FROM `oson_message`";
            $count = Db::query($sql1)['0']['num'];
            $sql2  = "SELECT * FROM `oson_message` LIMIT $offset,$size";
            $data  = Db::query($sql2);
            $best  = ceil($count/$size);
            $last  = $page-1<1?1:$page-1;
            $next = $page+1>$best?$best:$page+1;
              // "data"=>$data,
            $arr = array(
                "dataall"=>$data,
                "best"=>$best,
                "last"=>$last,
                "next"=>$next,
                );
            // print_r($arr);die;
            // $this->assign("data",$data);
            // $this->assign("best",$best);
            // $this->assign("last",$last);
            // $this->assign("next",$next);
            // $data  = $this->Model->Select("oson_message");
            // print_r($arr);
            // $this->assign("data",$data);
            return view("Messages",["data"=>$arr]);
    }
    public function sendemail()
    {

        $request = Request::instance();
        $msg_id=$this->xss($request->get('msg_id'));
        $sql="select * from oson_message where msg_id='$msg_id'";
        $data=Db::query($sql);

        return view("Messages_show",["data"=>$data]);
    }
    public function msgemail(){
        $request = Request::instance();
        $leave_email = $this->xss($request->post("msg_email"));
        $leave_reply = $this->xss($request->post("reply_desc"));
        $mail = new PHPMailer();
        // 使用SMTP方式发送
        $mail->IsSMTP();
        // 设置邮件的字符编码
        $mail->CharSet='UTF-8';
        // 企业邮局域名
        $mail->Host = 'smtp.qq.com';
        //---------qq邮箱需要的------//设置使用ssl加密方式登录鉴权
        $mail->SMTPSecure = 'ssl';
        //设置ssl连接smtp服务器的远程服务器端口号 可选465或587
        $mail->Port = 465;//---------qq邮箱需要的------
        // 启用SMTP验证功能
        $mail->SMTPAuth = true;
        //邮件发送人的用户名(请填写完整的email地址)
        $mail->Username = '1094989008@qq.com' ;
        // 邮件发送人的 密码 （授权码）
        $mail->Password = 'tywhtpgjzhtricec';  //修改为自己的授权码
        //邮件发送者email地址
        $mail->From ='1094989008@qq.com';
        //发送邮件人的标题
        $mail->FromName ='1094989008@qq.com';
        //收件人的邮箱 给谁发邮件
        $email_addr = $leave_email;
        //收件人地址，可以替换成任何想要接收邮件的email信箱,格式是AddAddress("收件人email","收件人姓名")
        $mail->AddAddress("$email_addr", substr(  $email_addr, 0 , strpos($email_addr ,'@')));
        //回复的地址
        $mail->AddReplyTo('1094989008@qq.com' , "" );
        //$mail->AddAttachment("./mail.rar"); // 添加附件
        // set email format to HTML //是否使用HTML格式
        $mail->IsHTML(true);
        //邮件标题
        $mail->Subject = '感谢您的建议欧讯cms已收到';
        //邮件内容
        $mail->Body =  $leave_reply;
        if( !$mail->Send() ){
            $mail_return_arr['mark'] = false ;
            $str  =  "邮件发送失败. <p>";
            $str .= "错误原因: " . $mail->ErrorInfo;
            $mail_return_arr['info'] = $str ;
        }else{
            $mail_return_arr['mark'] = true ;
            $str =  "邮件发送成功";
            $mail_return_arr['info'] = $str ;
        }
        if ($mail_return_arr['mark'] == 1) {
            $this->success('邮件发送成功','Message/showmsg');
        }else{
            return json(['state'=>0,"message"=>"邮件发送失败"]);
        }
    }

}