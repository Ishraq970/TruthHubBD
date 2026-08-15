"use client";
import React, { useEffect, useState } from "react";
import { AlertTriangle, Camera, PlusCircle, Star, X } from "lucide-react";
import { businesses } from "../../data/mock/businesses";
import type { Business } from "../../types";

export function WriteReviewModal({
  open,
  onClose,
  initialBusiness,
  onShowSoon,
}: {
  open: boolean;
  onClose: () => void;
  initialBusiness?: Business | null;
  onShowSoon: (feature: string) => void;
}) {
  const [selectedEntityId, setSelectedEntityId] = useState<number>(
    initialBusiness?.id || businesses[0].id
  );
  const [rating, setRating] = useState(5);
  const [hoverRating, setHoverRating] = useState(0);
  const [title, setTitle] = useState("");
  const [body, setBody] = useState("");
  const [date, setDate] = useState("2026-08-15");
  const [conflict, setConflict] = useState("No conflict of interest (Independent Customer)");
  const [scamAlertRequested, setScamAlertRequested] = useState(false);
  const [selectedImage, setSelectedImage] = useState<string | null>(null);

  useEffect(() => {
    if (initialBusiness) {
      setSelectedEntityId(initialBusiness.id);
    }
  }, [initialBusiness]);

  useEffect(() => {
    if (!open) return;
    const listener = (e: KeyboardEvent) => e.key === "Escape" && onClose();
    document.addEventListener("keydown", listener);
    return () => document.removeEventListener("keydown", listener);
  }, [open, onClose]);

  if (!open) return null;

  const handleImageChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    if (e.target.files && e.target.files[0]) {
      const file = e.target.files[0];
      setSelectedImage(URL.createObjectURL(file));
    }
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    onClose();
    onShowSoon("Community Review Submission Pipeline");
  };

  return (
    <div
      className="modal-overlay"
      onMouseDown={(e) => e.target === e.currentTarget && onClose()}
      style={{ overflowY: "auto", padding: "20px 16px" }}
    >
      <div
        className="review-modal-box"
        role="dialog"
        aria-modal="true"
        aria-labelledby="write-review-title"
      >
        <button
          className="modal-close-btn"
          onClick={onClose}
          aria-label="Close modal"
        >
          <X size={18} />
        </button>

        <div className="review-modal-header">
          <h2 id="write-review-title" className="review-modal-title">
            Write a Review
          </h2>
          <p className="review-modal-subtitle">
            Structured experience submission. Reviews attach to canonical entities.
          </p>
        </div>

        <form onSubmit={handleSubmit} className="review-form-content">
          {/* 1. What entity are you reviewing? */}
          <div className="entity-select-field">
            <div className="entity-select-top">
              <label htmlFor="entity-select" className="review-label">
                1. What entity are you reviewing?
              </label>
              <button
                type="button"
                className="btn-missing-entity"
                onClick={() => {
                  onClose();
                  onShowSoon("Add Missing Canonical Entity");
                }}
              >
                <PlusCircle size={14} /> Entity missing? Add it to TruthHubBD
              </button>
            </div>
            <select
              id="entity-select"
              className="review-input-select"
              value={selectedEntityId}
              onChange={(e) => setSelectedEntityId(Number(e.target.value))}
            >
              {businesses.map((b) => (
                <option key={b.id} value={b.id}>
                  {b.name} ({b.category} - {b.location})
                </option>
              ))}
            </select>
          </div>

          {/* Overall Rating */}
          <div className="review-form-group">
            <label className="review-label">Overall Rating *</label>
            <div className="rating-interactive-row">
              <div className="stars-cluster">
                {[1, 2, 3, 4, 5].map((star) => (
                  <button
                    type="button"
                    key={star}
                    className="star-btn"
                    onClick={() => setRating(star)}
                    onMouseEnter={() => setHoverRating(star)}
                    onMouseLeave={() => setHoverRating(0)}
                    aria-label={`Rate ${star} stars`}
                  >
                    <Star
                      size={24}
                      className={
                        star <= (hoverRating || rating) ? "star-fill" : "star-empty"
                      }
                    />
                  </button>
                ))}
              </div>
              <span className="rating-text-score">{hoverRating || rating} / 5</span>
            </div>
          </div>

          {/* Review Title */}
          <div className="review-form-group">
            <label htmlFor="review-title" className="review-label">
              Review Title *
            </label>
            <input
              id="review-title"
              type="text"
              className="review-input"
              placeholder="Summarize your key experience in a clear headline..."
              value={title}
              onChange={(e) => setTitle(e.target.value)}
              required
            />
          </div>

          {/* Experience Details */}
          <div className="review-form-group">
            <label htmlFor="review-body" className="review-label">
              Experience Details *
            </label>
            <textarea
              id="review-body"
              className="review-textarea"
              rows={4}
              placeholder="Describe what happened clearly and factual..."
              value={body}
              onChange={(e) => setBody(e.target.value)}
              required
            />
          </div>

          {/* Image Add Option */}
          <div className="review-form-group">
            <label className="review-label">Add Photos / Receipts (Optional)</label>
            <label className="image-upload-zone">
              <input
                type="file"
                accept="image/*"
                onChange={handleImageChange}
                style={{ display: "none" }}
              />
              {selectedImage ? (
                <div className="uploaded-preview-wrap">
                  <img src={selectedImage} alt="Uploaded preview" className="uploaded-preview-img" />
                  <span className="uploaded-change-text">Click to change photo</span>
                </div>
              ) : (
                <div className="upload-placeholder">
                  <Camera size={20} className="upload-icon" />
                  <span>Upload receipt, invoice, or experience photos</span>
                </div>
              )}
            </label>
          </div>

          {/* 2 Columns: Date & Conflict */}
          <div className="review-grid-2">
            <div className="review-form-group">
              <label htmlFor="exp-date" className="review-label">
                Experience Date
              </label>
              <input
                id="exp-date"
                type="date"
                className="review-input"
                value={date}
                onChange={(e) => setDate(e.target.value)}
              />
            </div>

            <div className="review-form-group">
              <label htmlFor="conflict-select" className="review-label">
                Conflict of Interest Disclosure
              </label>
              <select
                id="conflict-select"
                className="review-input-select"
                value={conflict}
                onChange={(e) => setConflict(e.target.value)}
              >
                <option value="No conflict of interest (Independent Customer)">
                  No conflict of interest (Independent Customer)
                </option>
                <option value="Incentivized review">Incentivized review</option>
                <option value="Affiliated / Business Partner">
                  Affiliated / Business Partner
                </option>
              </select>
            </div>
          </div>

          {/* Request Scam Alert Classification */}
          <div className="scam-alert-checkbox-box">
            <div className="scam-box-top">
              <div className="scam-box-title">
                <AlertTriangle size={17} color="#be123c" />
                <span>Request Scam Alert Classification</span>
              </div>
              <input
                type="checkbox"
                checked={scamAlertRequested}
                onChange={(e) => setScamAlertRequested(e.target.checked)}
                className="scam-checkbox"
                aria-label="Request scam alert classification"
              />
            </div>
            <p className="scam-box-note">
              Scam Alert is a moderated evidence workflow, not an instant accusation badge. Evidence is stored privately by default.
            </p>
          </div>

          {/* Submit Button */}
          <button type="submit" className="btn-submit-review">
            Submit Structured Review
          </button>
        </form>
      </div>
    </div>
  );
}
