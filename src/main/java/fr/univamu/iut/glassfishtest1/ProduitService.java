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
        return produitRepo.getProduit(id);
    }

    public List<Produit> getAllProduits() {
        return produitRepo.getProduits();
    }

    public void createProduit(Produit produit) {
        produitRepo.createProduit(produit);
    }

    public void updateProduit(Produit produit) {
        produitRepo.updateProduit(produit);
    }

    public void deleteProduit(int id) {
        produitRepo.deleteProduit(id);
    }
}