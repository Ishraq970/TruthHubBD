"use client";
import React from "react";
import { Star } from "lucide-react";

export function Stars({ rating, label = true }: { rating: number; label?: boolean }) {
  return (
    <span className="stars" aria-label={`${rating} out of 5 stars`}>
      <Star size={16} fill="currentColor" />
      {label && <strong>{rating.toFixed(1)}</strong>}
    </span>
  );
}
