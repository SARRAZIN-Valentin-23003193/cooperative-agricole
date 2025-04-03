package fr.univamu.iut.glassfishtest1;

import jakarta.enterprise.context.ApplicationScoped;
import jakarta.inject.Inject;

import java.util.ArrayList;
import java.util.List;

@ApplicationScoped
public class ProduitService {
    protected ProduitRepositoryInterface produitRepo;

    public ProduitService() {
    }

    @Inject
    public ProduitService(@DatabaseConnection ProduitRepositoryInterface produitRepo) {
        this.produitRepo = produitRepo;
    }

    public ArrayList<Produit> getProduits() {
        return (ArrayList<Produit>) produitRepo.getProduits();
    }

    public Produit getProduit(int id) {
        return produitRepo.getProduitById(id);
    }

    public List<Produit> getAllProduits() {
        return produitRepo.getProduits();
    }

    public void createProduit(Produit produit) {
        if (produit == null) {
            throw new IllegalArgumentException("Le produit ne peut pas être null");
        }
        try {
            produitRepo.createProduit(produit);
        } catch (Exception e) {
            throw new RuntimeException("Erreur lors de la création du produit: " + e.getMessage());
        }
    }

    public void updateProduit(Produit produit) {
        if (produit == null) {
            throw new IllegalArgumentException("Le produit ne peut pas être null");
        }
        if (produit.getId() <= 0) {
            throw new IllegalArgumentException("L'ID du produit doit être positif");
        }
        try {
            produitRepo.updateProduit(produit);
        } catch (Exception e) {
            throw new RuntimeException("Erreur lors de la mise à jour du produit: " + e.getMessage());
        }
    }

    public void deleteProduit(int id) {
        produitRepo.deleteProduit(id);
    }
}