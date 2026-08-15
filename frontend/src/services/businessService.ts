import { businesses } from "../data/mock/businesses";
import type { Business } from "../types";

export const businessService = {
  getFeatured: (): Business[] => businesses.slice(0, 6),
  
  getBySlug: (slug: string): Business | undefined =>
    businesses.find((item) => item.slug === slug),
    
  search: (query: string, category = "All", minRating = 0): Business[] => {
    const needle = query.trim().toLowerCase();
    
    return businesses.filter((item) => {
      // Category match
      const categoryMatch =
        category === "All" ||
        category === "All Categories" ||
        item.category.toLowerCase() === category.toLowerCase() ||
        item.category.toLowerCase().includes(category.toLowerCase());

      // Rating match
      const ratingMatch = minRating <= 0 || item.rating >= minRating;

      // Text match (name, Bengali name, category, location, description)
      const searchable = [
        item.name,
        item.bengaliName || "",
        item.category,
        item.location,
        item.description,
      ]
        .join(" ")
        .toLowerCase();

      const textMatch = !needle || searchable.includes(needle);

      return categoryMatch && ratingMatch && textMatch;
    });
  },
};
