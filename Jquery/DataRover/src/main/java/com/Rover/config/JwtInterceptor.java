package com.Rover.config;

import org.springframework.stereotype.Component;
import org.springframework.web.servlet.HandlerInterceptor;

import io.jsonwebtoken.JwtException;
import io.jsonwebtoken.Jwts;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;

@Component
public class JwtInterceptor implements HandlerInterceptor {

    private static final String AUTHORIZATION_HEADER = "Authorization";
//    private static final String TOKEN_PREFIX = "Bearer ";

    @SuppressWarnings("deprecation")
	@Override
    public boolean preHandle(HttpServletRequest request, HttpServletResponse response, Object handler)
            throws Exception {

        String token = request.getHeader(AUTHORIZATION_HEADER);

//        if (token != null && token.startsWith(TOKEN_PREFIX)) {
            if (token != null ) {

            String secret = "+Pm3mQ9BnNJy3E3h5J90E8+DjoitTunV/nS5GOWCuau0WEuhexg/ze112Wte9fYwEW+jJX9KoRBMCSd499p83w==";
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
