package com.Rover.Insert;

import java.util.HashMap;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
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

}
