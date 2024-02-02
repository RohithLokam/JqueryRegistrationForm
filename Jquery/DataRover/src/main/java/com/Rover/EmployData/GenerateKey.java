package com.Rover.EmployData;


import java.sql.Date;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.springframework.beans.factory.annotation.Value;
import org.springframework.stereotype.Component;
import org.springframework.web.servlet.HandlerInterceptor;

import io.jsonwebtoken.Claims;
import io.jsonwebtoken.Jwts;
import io.jsonwebtoken.JwtException;
import io.jsonwebtoken.SignatureAlgorithm;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;

@Component
public class GenerateKey implements HandlerInterceptor {

	
//	@Value("${secret}")
//	private static String secret;

	@SuppressWarnings("deprecation")
	public String generateKey(String email, List<Map<String, Object>> result) {
		String secret="+Pm3mQ9BnNJy3E3h5J90E8+DjoitTunV/nS5GOWCuau0WEuhexg/ze112Wte9fYwEW+jJX9KoRBMCSd499p99w==";

        Map<String, Object> claims = new HashMap<>();
        for (Map<String, Object> item : result) {
            for (Map.Entry<String, Object> entry : item.entrySet()) {
                claims.put(entry.getKey(), entry.getValue());
            }
        }

        return Jwts.builder()
                .setClaims(claims)
                .setSubject(email)
                .setIssuedAt(new Date(System.currentTimeMillis()))
                .setExpiration(new Date(System.currentTimeMillis() + 1000 * 60 * 11))
                .signWith(SignatureAlgorithm.HS512, secret)
                .compact();
    }
    
    
//    public Claims verify(String authorization) throws Exception {
//		String secret="+Pm3mQ9BnNJy3E3h5J90E8+DjoitTunV/nS5GOWCuau0WEuhexg/ze112Wte9fYwEW+jJX9KoRBMCSd499p99w==";
//
//        try {
//            @SuppressWarnings("deprecation")
//			Claims claims = Jwts.parser().setSigningKey(secret).parseClaimsJws(authorization).getBody();
//            System.out.println("claims : "+claims);
//            return claims;
//        } catch(Exception e) {
//        	
//            throw new AccessDeniedException("Access Denied");
//        }
//
//    }
    
    
    private static final String AUTHORIZATION_HEADER = "Authorization";
	String secret="+Pm3mQ9BnNJy3E3h5J90E8+DjoitTunV/nS5GOWCuau0WEuhexg/ze112Wte9fYwEW+jJX9KoRBMCSd499p99w==";

//  private static final String TOKEN_PREFIX = "Bearer ";
  @SuppressWarnings("deprecation")
	@Override
  public boolean preHandle(HttpServletRequest request, HttpServletResponse response, Object handler)
          throws Exception {
      String token = request.getHeader(AUTHORIZATION_HEADER);
//      if (token != null && token.startsWith(TOKEN_PREFIX)) {
          if (token != null ) {
          try {
              Claims claims = Jwts.parser().setSigningKey(secret).parseClaimsJws(token).getBody();
//        	  Jwts.parser().setSigningKey(secret).parseClaimsJws(token.substring(0));
              String firstName = (String) claims.get("firstName");
              String lastName = (String) claims.get("lastName");
              System.out.println("First Name: " + firstName);
              System.out.println("Last Name: " + lastName);
              return true; 
          } catch (JwtException e) {
              response.sendError(HttpServletResponse.SC_UNAUTHORIZED, "Invalid token");
              return false;
          }
      } else {
          response.sendError(HttpServletResponse.SC_UNAUTHORIZED, "Missing or invalid token");
          return false;
      }
  }
}