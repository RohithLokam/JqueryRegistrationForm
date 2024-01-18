package com.Rover.Insert;

import java.nio.file.Path;
import java.nio.file.Paths;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.security.crypto.bcrypt.BCryptPasswordEncoder;
import org.springframework.stereotype.Service;

@Service
public class InsertService {
	
	@Autowired
	JdbcTemplate jt;
	
	public Map<String, String> insert(Insert insert){
		Map<String,String> response=new HashMap<String,String>();
		try {
		int id=insert.id;
		String name=insert.name;
		int marks=99;
		String sql="insert into students values(?,?,?)";
		int i=jt.update(sql,id,name,marks);
		if(i>0) {
			response.put("success", "data inserted");
		}else {
			response.put("failure", "data not inserted");
		}
		}catch(Exception e) {
			response.put("error" ,e.toString());
		}
		return response;
	}
	
	public Map<String, String> secure(Insert insert){
		BCryptPasswordEncoder bcrypt=new BCryptPasswordEncoder();

		Map<String,String> response=new HashMap<String,String>();
		try {
		String fname=insert.getFname();
		String lname=insert.getLname();
		String password=insert.getPassword();
		
		String encryprtpassword=bcrypt.encode(password);
		
		String sql="insert into testing values(?,?,?)";
		int i=jt.update(sql,fname,lname,encryprtpassword);
		if(i>0) {
			response.put("success", "data inserted");
		}else {
			response.put("failure", "data not inserted");
		}
		}catch(Exception e) {
			response.put("error" ,e.toString());
		}
		return response;
	}
	
	public Map<String, String> login(Insert insert){
		BCryptPasswordEncoder bcrypt=new BCryptPasswordEncoder();
	
		Map<String,String> response=new HashMap<String,String>();
		try {
		String fname=insert.getFname();
		String password=insert.getPassword();
		String sql="select password from testing where fname=?";
		List<Map<String, Object>> result=new ArrayList<Map<String,Object>>();
		result =jt.queryForList(sql,fname);
		 Map<String, Object> userData = result.get(0);
         String encryptPassword = (String) userData.get("password");
		
		if(bcrypt.matches(password, encryptPassword)) {
			response.put("success", "Authentication Successfully");
		}else {
			response.put("failure", "Invalid Credentials");
		}
		}catch(Exception e) {
			response.put("error" ,e.toString());
		}
		return response;
	}
	
	

}
