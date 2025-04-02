package fr.univamu.iut.APIPU;

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
    
    public boolean Authentificate(String mail, String password) {
        User user = userRepo.Authentificate(mail, password);
        if (user != null) {
            return true;
        } else {
            return false;
        }
    }
}
