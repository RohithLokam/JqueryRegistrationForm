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
	
	
//	public Map<String, Object> selection(String name1){
//		Map<String, Object> response=new HashMap<String, Object>();
//		List<Map<String, Object>> result=new ArrayList<Map<String, Object>>();
//		String name=name1;
////		String name=name1.getName();
//		
//		String sql="select * from employ_data where 9=9 ";
//		if(!name.equals("null")) {
//			String sq1=sql;
//			sq1=sq1+" and firstName like '"+name+"%' ";
//			result=jdbcTemplate.queryForList(sq1);
//			if(result.isEmpty()) {
//				String sq2=sql;
//				sq2=sq2+" and lastName like '"+name+"%' ";
//				System.out.println(sq2);
//				result=jdbcTemplate.queryForList(sq2);
//				if(result.isEmpty()) {
//					String sq3=sql;
//					sq3=sq3+" and userName like '"+name+"%' ";
//					result=jdbcTemplate.queryForList(sq3);
//				}if(result.isEmpty()) {
//					response.put("data", null);
//					response.put("success", false);
//					response.put("message", "no data found");
//					return response;
//				}
//			}
//			Map<String, Object> resultMap = new HashMap<>();    
//			for (Map<String, Object> row : result) {
//				String employId = String.valueOf(row.get("employId"));
//				resultMap.put(employId, row);
//			}	 
//			response.put("success", true);
//			response.put("data", resultMap);
//			response.put("message", "data retrived successfully.");
//			return response;
//
//		}else {
//			result=jdbcTemplate.queryForList(sql);
//		Map<String, Object> resultMap = new HashMap<>();    
//		for (Map<String, Object> row : result) {
//			String employId = String.valueOf(row.get("employId"));
//			resultMap.put(employId, row);
//		}	 
//			result=jdbcTemplate.queryForList(sql);
//			response.put("success", true);
//			response.put("data", resultMap);
//			response.put("message", "data retrived successfully.");
//			return response;
//
//		}
//		
//	}
	
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
