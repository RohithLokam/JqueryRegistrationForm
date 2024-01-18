package com.Rover.Insert;

import java.util.Map;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RestController;

@RestController
@CrossOrigin(origins = "*")
public class InsertController {
	
	@Autowired
	InsertService insertService;

	
	@PostMapping("register")
	public Map<String, String> insertion(@RequestBody Insert insert) {
		return insertService.insert(insert);
	}
	
	@PostMapping("encrypt")
	public Map<String, String> encryption(@RequestBody Insert insert) {
		return insertService.secure(insert);
	}
	
	@PostMapping("loggedin")
	public Map<String, String> authentication(@RequestBody Insert insert) {
		return insertService.login(insert);
	}
	


}
