"use client";
import React from "react";
import type { Review } from "../../types";
import { Stars } from "./Stars";

export function ReviewCard({ review }: { review: Review }) {
  return (
    <article className="review-card">
      <div className="review-head">
        <span className="avatar">{review.initials}</span>
        <div>
          <strong>{review.author}</strong>
          <span>{review.date}</span>
        </div>
        <Stars rating={review.rating} label={false} />
      </div>
      <h3>{review.title}</h3>
      <p>{review.body}</p>
      <div className="review-foot">
        Helpful to {review.helpfulCount} people{" "}
        <button type="button">Helpful</button>
      </div>
    </article>
  );
}
