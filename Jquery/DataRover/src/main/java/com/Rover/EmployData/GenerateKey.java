package com.Rover.EmployData;


import java.nio.file.AccessDeniedException;
import java.sql.Date;
import java.util.Base64;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import org.springframework.stereotype.Component;
import org.springframework.web.servlet.HandlerInterceptor;

import io.jsonwebtoken.Claims;
import io.jsonwebtoken.JwtException;
import io.jsonwebtoken.Jwts;
import io.jsonwebtoken.SignatureAlgorithm;
import io.jsonwebtoken.security.Keys;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;

@Component
public class GenerateKey implements HandlerInterceptor {
//   private static String secret="+Pm3mQ9BnNJy3E3h5J90E8+DjoitTunV/nS5GOWCuau0WEuhexg/ze112Wte9fYwEW+jJX9KoRBMCSd499p83w==";
//   private static String secret;

	@SuppressWarnings("deprecation")
	public String generateKey(String email, List<Map<String, Object>> result) {
//        byte[] keyBytes = Keys.secretKeyFor(SignatureAlgorithm.HS512).getEncoded();
//         secret = new String(Base64.getEncoder().encode(keyBytes));
//      System.out.println("Secret :  "+secret);
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
                .setExpiration(new Date(System.currentTimeMillis() + 1000 * 60 * 24))
                .signWith(SignatureAlgorithm.HS512, secret)
                .compact();
    }
    
    
    public Claims verify(String authorization) throws Exception {
		String secret="+Pm3mQ9BnNJy3E3h5J90E8+DjoitTunV/nS5GOWCuau0WEuhexg/ze112Wte9fYwEW+jJX9KoRBMCSd499p99w==";

        try {
            @SuppressWarnings("deprecation")
			Claims claims = Jwts.parser().setSigningKey(secret).parseClaimsJws(authorization).getBody();
            System.out.println("claims : "+claims);
            return claims;
        } catch(Exception e) {
        	
            throw new AccessDeniedException("Access Denied");
        }

    }
    
    
    private static final String AUTHORIZATION_HEADER = "Authorization";
//  private static final String TOKEN_PREFIX = "Bearer ";

  @SuppressWarnings("deprecation")
	@Override
  public boolean preHandle(HttpServletRequest request, HttpServletResponse response, Object handler)
          throws Exception {

      String token = request.getHeader(AUTHORIZATION_HEADER);
		String secret="+Pm3mQ9BnNJy3E3h5J90E8+DjoitTunV/nS5GOWCuau0WEuhexg/ze112Wte9fYwEW+jJX9KoRBMCSd499p99w==";


//      if (token != null && token.startsWith(TOKEN_PREFIX)) {
          if (token != null ) {
          try {
              Jwts.parser().setSigningKey(secret).parseClaimsJws(token.substring(0));
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