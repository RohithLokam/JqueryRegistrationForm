package com.Rover.EmployData;

import java.time.LocalDate;
import java.time.format.DateTimeFormatter;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Service;

@Service
public class EmployDataServiceInsert {
	static String username;

	@Autowired
	JdbcTemplate jdbcTemplate;

	public Map<String, Object> insertEmployData(EmployData employData){
		Map<String, Object> response=new HashMap<String, Object>();
		try {
			int count=0;
			String firstName=employData.getFirstName();
			String lastName=employData.getLastName();
			String userName=username;
			String dob=employData.getDob();
			String gender=employData.getGender();
			String skills=employData.getSkills();
			String email=employData.getEmail();
			String password=employData.getPassword();
			byte[] image=employData.getImage();


			String nameRegex="^[a-zA-Z]+$";
			String emailRegex="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\\.[a-zA-Z]{2,}$";
			String passwordRegex="^(?=.*[a-z])(?=.*[A-Z])(?=.*\\W).+$";
			if(firstName=="") {
				response.put("message", "first name can't be empty");
			}else if(!firstName.matches(nameRegex)) {
				response.put("message", "enter only characters in first name");
			}else {
				count++;
			}
			if(lastName=="") {
				response.put("message", "last name can't be empty");
			}else if(!lastName.matches(nameRegex)) {
				response.put("message", "enter only characters in last name");
			}else {
				count++;
			}
			if(email=="") {
				response.put("message", "email can't be empty");
			}else if(!email.matches(emailRegex)) {
				response.put("message", "invalid email format");
			}else {
				count++;
			}
			if(password=="") {
				response.put("message", "password can't be empty");
			}else if(!password.matches(passwordRegex)) {
				response.put("message", "invalid password format");
			}else {
				count++;
			}
			if (dob.equals("")) {
			    response.put("message", "Date of birth can't be empty");
			} else if (!LocalDate.parse(dob, DateTimeFormatter.ofPattern("yyyy-MM-dd")).isBefore(LocalDate.now().minusDays(1))) { 
			    response.put("message", "DOB must be in the past from the current date");
			} else {
			    count++;
			}



			LocalDate date=LocalDate.now();
			String addDate=date.toString();
			String modifyDate=addDate;
			String createdBy=userName;
			if(count==5) {
			String sql="insert into employ_data (firstName,lastName,userName,dob,gender,image,skills,email,password,addDate,modifyDate,createdBy)values(?,?,?,?,?,?,?,?,?,?,?,?)";
			int i=jdbcTemplate.update(sql,firstName,lastName,userName,dob,gender,image,skills,email,password,addDate,modifyDate,createdBy);
			if(i>0) {
				response.put("success", true);
				response.put("data", "");
				response.put("message", "Data Inserted");
			}else {
				response.put("success", false);
			
			}
			}else {
				response.put("success", false);
			}
			
		}catch(Exception e) {
			response.put("error",e.toString());
		}
		System.out.println(response);
		return response;
	}

	public Map<String, String> UserNameCheck(String firstName, String lastName) {
		String userName = usernam(firstName.charAt(0) + lastName);
		username = userName;
		Map<String, String> data = new HashMap<String, String>();
		String email = userName + "@miraclesoft.com";
		data.put("email", email);
		return data;
	}


	public String usernam(String userName) {
		String result = userName;
		String seequel="select * from employ_data where userName like'"+userName+"%'";
		List<Map<String,Object>> data=new ArrayList<Map<String,Object>>();
		data=jdbcTemplate.queryForList(seequel);
		if(data.size()>=1) {
			result=userName=userName+(data.size());	
		}
		return result;
	}

}
