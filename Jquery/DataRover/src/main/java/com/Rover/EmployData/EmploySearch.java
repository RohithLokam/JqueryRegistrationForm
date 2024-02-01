package com.Rover.EmployData;

import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Service;


@Service
public class EmploySearch {
	@Autowired
	JdbcTemplate jdbcTemplate;
	

	
	public Map<String, Object> selection(String name) {
	    Map<String, Object> response = new HashMap<>();
	    List<Map<String, Object>> result;

	    String sql = "select * from employ_data where 9=9";

	    if (!name.equals("null")) {
	        String[] columns = {"firstName", "lastName", "userName"};
	        for (String column : columns) {
	            String query = sql + " and " + column + " like '"+name+"%'";
	            result = jdbcTemplate.queryForList(query);
	            if (!result.isEmpty()) {
	            	Map<String, Object> resultMap = new HashMap<>();    
	    			for (Map<String, Object> row : result) {
	    				String employId = String.valueOf(row.get("employId"));
	    				resultMap.put(employId, row);
	    			}
	                response.put("success", true);
	                response.put("data", resultMap);
	                response.put("message", "Data retrieved successfully.");
	                return response;
	            }
	        }
	        response.put("data", null);
	        response.put("success", false);
	        response.put("message", "No data found");
	        return response;
	    } else {
	        result = jdbcTemplate.queryForList(sql);
        	Map<String, Object> resultMap = new HashMap<>();    
	        for (Map<String, Object> row : result) {
				String employId = String.valueOf(row.get("employId"));
				resultMap.put(employId, row);
			}
	        response.put("success", true);
	        response.put("data", resultMap);
	        response.put("message", "Data retrieved successfully.");
	        return response;
	    }
	}

}
