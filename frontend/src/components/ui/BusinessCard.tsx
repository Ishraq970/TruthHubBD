"use client";
import React from "react";
import { Link } from "react-router-dom";
import { ShieldCheck, Star } from "lucide-react";
import type { Business } from "../../types";

export function BusinessCard({ business }: { business: Business }) {
  return (
    <Link to={`/business/${business.slug}`} className="entity-card">
      <div className="entity-media">
        {business.image ? (
          <img src={business.image} alt={business.name} className="entity-thumb" loading="lazy" />
        ) : (
          <div className="entity-fallback" style={{ background: business.color || "#0f766e" }}>
            {business.name
              .split(" ")
              .map((w) => w[0])
              .join("")
              .slice(0, 2)}
          </div>
        )}
      </div>

      <div className="entity-content">
        <div className="entity-header">
          <h3 className="entity-name">{business.name}</h3>
          {business.verified && (
            <span className="entity-badge">
              <ShieldCheck size={13} className="badge-icon" />
              Verified Business
            </span>
          )}
        </div>

        <p className="entity-meta">
          {business.category} &bull; {business.location}
        </p>

        <div className="entity-rating-row">
          <div className="stars-cluster" aria-label={`Rating ${business.rating} out of 5`}>
            {[1, 2, 3, 4, 5].map((star) => (
              <Star
                key={star}
                size={14}
                className={star <= Math.round(business.rating) ? "star-fill" : "star-empty"}
              />
            ))}
          </div>
          <span className="rating-score">
            <strong>{business.rating.toFixed(1)}</strong> ({business.reviewCount} reviews)
          </span>
        </div>

        <p className="entity-desc">{business.description}</p>
      </div>
    </Link>
  );
}
