package com.Rover.config;

import org.springframework.context.annotation.Configuration;
import org.springframework.web.servlet.config.annotation.InterceptorRegistry;
import org.springframework.web.servlet.config.annotation.WebMvcConfigurer;

import com.Rover.EmployData.GenerateKey;

@Configuration
public class WebMvcConfig implements WebMvcConfigurer {

    @Override
    public void addInterceptors(InterceptorRegistry registry) {
        registry.addInterceptor(new GenerateKey())
        .addPathPatterns("/**")
        .excludePathPatterns("/employ", "/sendmail","/employ_data","/otp_verification","/password_update","/html","/user_name_check");
    }
}
