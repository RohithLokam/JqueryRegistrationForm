package com.Rover.EmployData;


import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.core.io.ByteArrayResource;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.mail.SimpleMailMessage;
import org.springframework.mail.javamail.JavaMailSender;
import org.springframework.mail.javamail.MimeMessageHelper;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.stereotype.Service;
import org.thymeleaf.TemplateEngine;

import jakarta.mail.internet.MimeMessage;

@Service
public class SendMail {
	
	@Autowired
	JavaMailSender jms;
	@Autowired
	JdbcTemplate jdbcTemplate;
	@Autowired
	TemplateEngine templateEngine;
	
	public Map<String,Object> sendMail(EmployData employData) {
		Map<String,Object> response=new HashMap<String,Object>();
		try {
			String email=employData.getEmail();
		SimpleMailMessage sm=new SimpleMailMessage();
		int min = 1111;  
		int max = 9999;  
		  int otpp = (int)(Math.random()*(max-min+1)+min);  
		String sql="select  email,employId from employ_data where email=?";
		List<Map<String,Object>> result=new ArrayList<Map<String,Object>>();
		System.out.println("Rohith : "+result);
		result=jdbcTemplate.queryForList(sql,email);
		System.out.println(result);
		if(!result.isEmpty()) {
			for(Map<String,Object> map:result) {
				String otppp= String.valueOf(otpp);
				map.put("otp", otppp);
				
			}
			response.put("success", true);
			response.put("message", "otp sending successfully.");
			response.put("data", result);
			sm.setFrom("rohithl4681@gmail.com");
			sm.setTo(email);
			System.out.println(otpp); 
			System.out.println(email); 
			System.out.println(result);
			
			sm.setText("Your ONE TIME PASSWORD is "+otpp+". Don't share with any one.");

			sm.setSubject("OTP Verification");
			jms.send(sm);
		}else {
			response.put("success", false);
			response.put("message", "otp not  sending.");
			response.put("data", null);
		}
		}catch(Exception e) {
			response.put("message", "error "+e);
		}
		return response;
	}
	
	public Map<String,Object> otpVerification(EmployData employData) {
		Map<String,Object> response=new HashMap<String,Object>();
		try {
			int otp=employData.getOtp();
		
			int userOtp = employData.getUser_otp();

			if(otp==userOtp) {
				response.put("success", true);
				response.put("message", "otp is valid");
				response.put("data", otp);
			}else {
				response.put("success", false);
				response.put("message", "otp is not valid");
				response.put("data",null);
			}
			
		}catch(Exception e) {
			response.put("message", "error :"+e);
		}
		return response;
	}
	
	public Map<String, Object> passwordUpdate(EmployData edp){
        BCryptPasswordEncoder bcrypt=new BCryptPasswordEncoder();
		Map<String, Object> response=new HashMap<String, Object>();
		try {
			String email=edp.getEmail();
			String password=edp.getPassword();

			System.out.println("email  :  "+email);
   			String encryprtpassword=bcrypt.encode(password);
			String sql="update employ_data set password=? where email=?";
			int i=jdbcTemplate.update(sql,encryprtpassword,email);
			if(i>0) {
				jdbcTemplate.update("update testing set password=? where email=?",password,email);
				response.put("success", true);
				response.put("message", "Password updated successfully");
			}else {
				response.put("success", false);
				response.put("message", "Password not updated");

			}		
		}catch(Exception e) {
			response.put("success", false);
			response.put("message", e.toString());
		}
		return response;
	}
	
	public Map<String, Object> htmlTemplate(byte[] file, String fileName, String firstName, String lastName, String userName, String email, String dob, String skills, String gender){
		Map<String,Object> response=new HashMap<String,Object>();
		try {
	        MimeMessage message = jms.createMimeMessage();
	        MimeMessageHelper helper = new MimeMessageHelper(message, true);
	        
	        byte[] fileData =file;

            helper.setTo("gudimetlasuvarna@gmail.com");
            helper.setSubject("New Employee Registration: ["+firstName.toUpperCase()+"]");

            	String mail="Dear Admin Team,<br/><br/>\r\n"
            			+ "\r\n\r\n"
            			+ "This email is to inform you that a new employee, ["+firstName.toUpperCase() +"], has registered on our company website.<br><br>"+"\r\n"
            			+ "<html xmlns=\"http://www.w3.org/1999/xhtml\">\r\n"
            			+ "<head>\r\n"
            			+ "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\r\n"
            			+ "<title>Miracle</title>\r\n"
            			+ "</head>\r\n"
            			+ "\r\n"
            			+ "<body>\r\n"
            			+ "	<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n"
            			+ "		<tr>\r\n"
            			+ "			<td align=\"center\" valign=\"top\" \r\n"
            			+ "				style=\"background-color: #838383;\"><br> <br>\r\n"
            			+ "				<table width=\"600\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">\r\n"
            			+ "					<tr>\r\n"
            			+ "						<td align=\"center\" valign=\"top\"\r\n"
            			+ "							style=\"background-image: url('https://hubble.miraclesoft.com/assets/img/bg-login.jpg'); font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #000000; padding: 0px 15px 10px 15px;\">\r\n"
            			+ "							\r\n"
            			+ "                            <form style=\"line-height: 1.8; color:white; background-image: url('https://hubble.miraclesoft.com/assets/img/bg-login.jpg'); padding: 7px;\">\r\n"
            			+ " \r\n"
            			+ "                           <h2>"+firstName+" "+lastName+"    \r\n"
            			+ "\r\n"
            			+ "                                <br><br>\r\n"
            			+ "                                <label>User name : </label>\r\n"
            			+ "                                <b><label id=\"userName\">"+userName+"</label></b>\r\n"
            			+ "                                <label>First name : </label>\r\n"
            			+ "                                <b><label id=\"firstName\">"+firstName+"</label></b><br>\r\n"
            			+ "                                <label class=\"last\">Last name : </label>\r\n"
            			+ "                                <b><label class=\"lastname\" id=\"lastName\">"+lastName+"</label></b>\r\n"
            			+ "                                <label>Dob : </label>\r\n"
            			+ "                                <b><label id=\"dob\">"+dob+"</label></b><br>\r\n"
            			+ "                                    <label>Gender :</label>\r\n"
            			+ "                                    <b><label id=\"gender\">"+gender+"</label></b><br>\r\n"
            			+ "                                    <label>Skills: </label>\r\n"
            			+ "                                    <b><label id=\"skills\">"+skills+"</label></b><br>\r\n"
            			+ "                                <label>Email</label>\r\n"
            			+ "                                <b><label id=\"Email\">"+email+"</label></b>\r\n"
            			+ "                            </form>\r\n"
            			+ "						</td>\r\n"
            			+ "					</tr>\r\n"
            			+ "				</table> <br> <br></td>\r\n"
            			+ "		</tr>\r\n"
            			+ "	</table>\r\n"
            			+ "</body>\r\n"
            			+ "</html>";
//            String htmlContent = templateEngine.process("email.html", templateModel);
            helper.setText(mail, true); 
//            helper.setText("New Employ registerd into an application", true); 

//            helper.addAttachment(fileName, new ByteArrayResource(fileData));
            helper.addInline(fileName, new ByteArrayResource(fileData), "image/png");
            jms.send(message);
          
			
		
		}catch(Exception e) {
			response.put("message", "error "+e);
		}
		return response;
	}


}