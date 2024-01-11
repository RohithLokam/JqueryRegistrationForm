package com.Rover.EmployData;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.mail.SimpleMailMessage;
import org.springframework.mail.javamail.JavaMailSender;
import org.springframework.stereotype.Service;

@Service
public class SendMail {
	
	@Autowired
	JavaMailSender jms;
	@Autowired
	JdbcTemplate jdbcTemplate;
	
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
		System.out.println(result);
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
//		
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
		Map<String, Object> response=new HashMap<String, Object>();
		try {
			String email=edp.getEmail();
			String password=edp.getPassword();

			System.out.println("email  :  "+email);
			String sql="update employ_data set password=? where email=?";
			int i=jdbcTemplate.update(sql,password,email);
			if(i>0) {
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


}