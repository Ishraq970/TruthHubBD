"use client";
import React, { useEffect } from "react";
import { ArrowRight, Sparkles, X } from "lucide-react";

export function ComingSoonModal({
  open,
  onClose,
  feature,
}: {
  open: boolean;
  onClose: () => void;
  feature: string;
}) {
  useEffect(() => {
    if (!open) return;
    const listener = (e: KeyboardEvent) => e.key === "Escape" && onClose();
    document.addEventListener("keydown", listener);
    return () => document.removeEventListener("keydown", listener);
  }, [open, onClose]);

  if (!open) return null;

  return (
    <div
      className="modal-overlay"
      onMouseDown={(e) => e.target === e.currentTarget && onClose()}
    >
      <div
        className="modal-box"
        role="dialog"
        aria-modal="true"
        aria-labelledby="coming-title"
      >
        <button
          className="modal-close-btn"
          onClick={onClose}
          aria-label="Close modal"
        >
          <X size={18} />
        </button>

        <div className="modal-icon-badge">
          <Sparkles size={24} />
        </div>

        <div className="trust-badge-pill" style={{ margin: "0 auto 10px" }}>
          Coming Soon
        </div>

        <h2 id="coming-title" className="modal-title">
          {feature}
        </h2>

        <p className="modal-desc">
          This feature is currently under active development and will be available soon.
        </p>

        <button className="btn primary full" onClick={onClose} style={{ marginTop: 16 }}>
          Continue exploring <ArrowRight size={16} />
        </button>
      </div>
    </div>
  );
}
