package fr.univamu.iut.glassfishtest1;

import jakarta.enterprise.context.ApplicationScoped;
import jakarta.inject.Inject;

@ApplicationScoped
public class UserService {
    protected UserRepositoryInterface userRepo;
    
    public UserService() {
        // Constructeur sans arguments requis par CDI
    }
    
    @Inject
    public UserService(@DatabaseConnection UserRepositoryInterface userRepo) {
        this.userRepo = userRepo;
    }
    
    public Integer Authentificate(String mail, String password) {
        return userRepo.Authentificate(mail, password);
    }
}
